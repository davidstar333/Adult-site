<!-- Like Widget -->
<div class="wg-actions-likes clearfix" ng-controller="likesWidgetCtrl" ng-init="init({{$config['id']}}, '{{$config['item']}}')" ng-cloak>
  <div class="pull-left">
    <strong><% totalLikes %></strong> Likes
  </div>
  <a ng-click="likeThis()" class="pull-right" ng-show="liked == 1">
    I like this
    <i class="fa fa-heart liked"></i>

  </a>
  <a ng-click="likeThis()" class="pull-right" ng-show="liked != 1">
    Unlike
    <i class="fa fa-heart"></i>

  </a>
</div>
<!-- end Widget -->