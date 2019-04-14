<?php
use App\Helpers\Helper as AppHelper;
?>
<div class="panel panel-default">
  <div class="panel-heading"> 
    <h4> 
      @lang('messages.earnings') 
      <?php 
      if(isset($config['performer'])){ ?>
        @lang('messages.of') 
      <?php       
        echo $config['performer']->username;
      }
      ?>
      <span class="pull-right">@lang('messages.myBalance'): ${{AppHelper::getTotalEarned($config['performerId'])}}</span>
    </h4>
  </div>
  <div class="right_cont panel-body"> <!--all left-->
    <div class="mod_earnings_cont" ng-controller="modelEarningCtrl" ng-cloak ng-init="earningInit('{{$config['performerId']}}')">
      <form class="form-inline" ng-submit="submitFilterPeriod(frmFilterPeriod)" name="frmFilterPeriod" novalidate>
        <div class="">
          <div class="col-sm-2">
            <label for="orient" class="control-label">@lang('messages.groupBy')</label>
            <select class="form-control" id="orient" ng-model="timePeriod.group" ng-change="changeGroup()">
              <option value="day" ng-selected="true">@lang('messages.day')</option>
              <option value="month">@lang('messages.month')</option>
              <option value="none">@lang('messages.none')</option>
            </select>
          </div>
          <div class="col-sm-3">
            <label class="control-label">@lang('messages.from')</label>
            <input type="text" class="form-control" name="timePeriodStart" ng-model="timePeriod.start" value=""
                  placeholder="Start Date" id="timePeriodStart" ng-required="true">
            <span ng-show="frmFilterPeriod.$submitted && frmFilterPeriod.timePeriodStart.$error.required"
                  class="label label-danger">@lang('messages.thisFieldIsRequired')</span>
          </div>
          <div class="col-sm-3">
            <label class="control-label">@lang('messages.to')</label>
            <input type="text" class="form-control" name="timePeriodEnd" value="" placeholder="End Date" ng-model="timePeriod.end" id="timePeriodEnd" ng-required="true">
            <span ng-show="frmFilterPeriod.$submitted && frmFilterPeriod.timePeriodEnd.$error.required"
                  class="label label-danger">@lang('messages.thisFieldIsRequired')</span>
          </div>
          <div class="col-sm-2">
            <label class="control-label">&nbsp;</label>
            <button type="submit" class="btn btn-rose btn-danger">@lang('messages.submit')</button>
          </div>
          <div class="col-sm-2">
            <label class="control-label">&nbsp;</label>
            <button type="button" class="btn btn-rose btn-primary" ng-click="download()">@lang('messages.download')</button>
          </div>
        </div>

      </form>
      <div class="clear">&nbsp;</div>
      <div class="report-main" ng-show="timePeriod.group == 'day' || timePeriod.group == 'month'">
        <div class="report-title font fleft">
          <legend class="pull-left text-primary"
                ng-show="timePeriod.start && timePeriod.end">@lang('messages.yourSelectedPeriod'): <% timePeriod.start %> - <% timePeriod.end %></legend>
        </div>
        <div class="earning-report">
          <div class="report-header">
            <div class="col-sm-6 report-cell">
              <strong>@lang('messages.timePeriod')</strong>
            </div>
            <div class="col-sm-4 report-cell report-cell-dark">
              <span class="fleft">Earnings <i class="fa fa-bar-chart pull-right"></i></span>

            </div>
            <div class="col-sm-2 report-cell report-cell-black">
              Details
            </div>
          </div>
          <div class="clear"> &nbsp;</div>
          <div class="earning-content">
            <div class="row" ng-show="earnings.length > 0" ng-repeat="(key, earning) in earnings">
              <div class="col-sm-12">
                <div class="col-sm-6 report-cell" >
                  <span><% earning.datetime %></span>
                </div>
                <div class="col-sm-4 report-cell">
                  <span><% earning.totalTokens %> Tokens</span>
                </div>
                <div class="col-sm-2 report-cell">
                  <span><a ng-click="showDayDetail(key, earning.datetime)" class="btn btn-link"><span ng-show="!earning.details">Show Detail</span><span ng-show="earning.details">Less Detail</span></a></span>
                </div>
              </div>

              <div class="col-sm-12" id="report-detail-day-<% key %>" ng-show="earning.details">
                <table class="table">
                  <tr>
                    <th>@lang('messages.item')</th>
                    <th>Tokens</th>
                    <th>@lang('messages.from')</th>
                    @if($userData->role === 'studio')
                    <th>@lang('messages.model')</th>
                    @endif
                    <th>@lang('messages.status')</th>
                    <th>@lang('messages.date')</th>
                  </tr>
                  <tr ng-repeat="item in earning.details">
                    <td><% item.item | itemType %></td>
                    <td><% item.tokens %></td>
                    <td><% item.fromName | elipsis:15 %></td>
                    @if($userData->role === 'studio')
                    <td><% item.modelName | elipsis:15 %></td>
                    @endif
                    <td><% item.status %></td>
                    <td><% item.createdAt %></td>
                  </tr>
                </table>
              </div>
            </div>

          </div>
          <div class="row"  ng-show="earnings.length == 0 && submitSearch">
            <div class="alert alert-warning">@lang('messages.noResultsFound')</div>
          </div>
          <div class="row"  ng-show="!submitSearch && earnings.length == 0">
            <div class="alert alert-warning">@lang('messages.selectAPeriodOfTimeFirst')</div>
            <div class="clear">&nbsp;</div>
          </div>
          <!--        <div class="col-sm-12" ng-show="pagination > 1">
                    <a ng-click="loadMoreReport()">Load More</a>
                  </div>-->
        </div>

        <div class="clear">&nbsp;</div>
      </div>
      <div class="report-main" ng-show="timePeriod.group == 'none'">
        <div class="earning-report">
          <div class="report-header">
            <div class="col-sm-2 report-cell">
              <strong>@lang('messages.commissionTime')</strong>
            </div>
            <div class="col-sm-2 report-cell report-cell-dark">
              <span>@lang('messages.amount')</span>
              <i class="fa fa-sort-amount-desc"></i>
            </div>
            <div class="col-sm-2 report-cell report-cell-light">
              <span>@lang('messages.type')</span>
              <i class="fa fa-filter"></i>
            </div>
            <div class="col-sm-2 report-cell report-cell-black">
              <span>@lang('messages.from')</span>
            </div>
            <div class="col-sm-2 report-cell report-cell-black">
              <span>@lang('messages.status')</span>
            </div>
            <div class="col-sm-2 report-cell report-cell-black">
              @lang('messages.details')
            </div>
          </div>
          <div class="clear">&nbsp;</div>
          <div class="earning-content">
            <div class="row" ng-show="earnings.length > 0" ng-repeat="(key, earning) in earnings">
              <div class="col-sm-12">
                <div class="col-sm-2 report-cell" >
                  <span><% earning.datetime %></span>
                </div>
                <div class="col-sm-2 report-cell">
                  <span><% earning.tokens %> Tokens</span>
                </div>
                <div class="col-sm-2 report-cell">
                  <span><% earning.type | spaceCapitalLetters | ucFirst %></span>
                </div>
                <div class="col-sm-2 report-cell">
                  <span><% earning.username %></span>
                </div>
                <div class="col-sm-2 report-cell">
                  <span><% earning.status %></span>
                </div>
                <div class="col-sm-2 report-cell">
                  <span><a ng-click="showNoneDetail(key, earning.id)"><span ng-show="!earning.detail">Show Detail</span><span ng-show="earning.detail">Less Detail</span></a></span>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="col-sm-12" id="report-detail-none-<% key %>" ng-if="earning.detail">
                  <table class="table">
                    <tr>
                      <th>@lang('messages.item')</th>
                      <th>Tokens</th>
                      <th>@lang('messages.from')</th>  
                      @if($userData->role === 'studio')                    
                      <th>@lang('messages.model')</th>
                      @endif
                      <th>@lang('messages.status')</th>
                      <th>@lang('messages.date')</th>
                    </tr>
                    <tr>
                      <td><% earning.detail.item %></td>
                      <td><% earning.detail.tokens %></td>
                      <td><% earning.detail.fromName | elipsis:15 %></td>
                      @if($userData->role === 'studio')
                      <td><% earning.detail.modelName | elipsis:15 %></td>
                      @endif
                      <td><% earning.detail.status %></td>
                      <td><% earning.detail.createdAt %></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>

          </div>
          <div class="row"  ng-show="earnings.length == 0 && submitSearch">
            <div class="alert alert-warning">@lang('messages.noResultsFound')</div>
          </div>
          <div class="row"  ng-show="!submitSearch && earnings.length == 0">
            <div class="alert alert-warning"><div class="alert alert-warning">@lang('messages.selectAPeriodOfTimeFirst')</div></div>
          </div>
        </div>

        <div class="clear">&nbsp;</div>
        <!--      <div class="col-sm-12" ng-show="pagination > 1">
                <a ng-click="loadMoreReport()">Load More</a>
              </div>-->
      </div>

      <div class="clear">&nbsp;</div>
    </div>
  </div>
</div>