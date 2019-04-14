<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\CsvExport;
use Nayjest\Grids\Components\ExcelExport;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\Laravel5\Pager;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\ShowingRecords;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use App\Modules\Api\Models\ChatThreadModel;
use App\Helpers\Helper as AppHelper;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\EarningModel;

class PerformerStats extends AbstractWidget {

  /**
   * The configuration array.
   *
   * @var array
   */
  protected $config = [];

  /**
   * Treat this method as a controller action.
   * Return view() or other content to display.
   */
  public function run() {
    $query = UserModel::select('users.*', 'users.id as check', 'users.id as action')
            ->where('users.role', $this->config['role']);
    if (isset($this->config['studioId'])) {
      $query->where('users.parentId', $this->config['studioId']);
    }

    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
                new EloquentDataProvider($query)
        )
        ->setName('Models')
        ->setPageSize(10)
        ->setColumns([
            (new FieldConfig)
            ->setName('username')
            ->setLabel('Performer')
            ->setCallback(function ($val) {
                      return "<span class='glyphicon glyphicon-user'></span>{$val}";
                    })
            ->setSortable(true)
            ->addFilter(
                    (new FilterConfig)
                    ->setOperator(FilterConfig::OPERATOR_LIKE)
            ),
            (new FieldConfig)
            ->setName('earn')
            ->setLabel('Earned')
            ->setCallback(function ($val, $row) {
                      $item = $row->getSrc();
                      $earning = EarningModel::getMyEarned($item, 'all');
                      return ($earning->totalTokens) ? $earning->totalTokens : '';
                    })
            ,
            (new FieldConfig)
            ->setName('tip')
            ->setLabel('Tip')
            ->setCallback(function ($val, $row) {
                      $item = $row->getSrc();
                      $earning = EarningModel::getMyEarned($item, 'all', 'tip');
                      return ($earning->totalTokens) ? $earning->totalTokens : '';
                    }),
            (new FieldConfig)
            ->setName('privateChat')
            ->setLabel('Private Chat')
            ->setCallback(function ($val, $row) {
                      $item = $row->getSrc();
                      $chatThread = ChatThreadModel::getStreamingTime($item->id, 'private');
                      return ($chatThread->totalStreaming) ? AppHelper::convertToHoursMins($chatThread->totalStreaming) : '';
                    }),
            (new FieldConfig)
            ->setName('groupChat')
            ->setLabel('Group Chat')
            ->setCallback(function ($val, $row) {
                      $item = $row->getSrc();
                      $chatThread = ChatThreadModel::getStreamingTime($item->id, 'group');
                      return ($chatThread->totalStreaming) ? AppHelper::convertToHoursMins($chatThread->totalStreaming) : '';
                    })
        ])
        ->setComponents([
            (new THead)
            ->setComponents([
                (new ColumnHeadersRow),
                (new FiltersRow)
                ,
                (new OneCellRow)
                ->setRenderSection(RenderableRegistry::SECTION_END)
                ->setComponents([
                    (new RecordsPerPage)
                    ->setVariants([
                        10,
                        20,
                        30,
                        40,
                        50,
                        100,
                        200,
                        300,
                        400,
                        500
                    ]),
                    new ColumnsHider,
                    (new CsvExport)
                    ->setFileName('my_report' . date('Y-m-d'))
                    ,
                    (new ExcelExport())
                    ->setFileName('Models-' . date('Y-m-d'))->setSheetName('Excel sheet'),
                    (new HtmlTag)
                    ->setContent('<span class="glyphicon glyphicon-refresh"></span> Filter')
                    ->setTagName('button')
                    ->setRenderSection(RenderableRegistry::SECTION_END)
                    ->setAttributes([
                        'class' => 'btn btn-success btn-sm',
                        'id' => 'formFilter'
                    ])
                ])
            ])
            ,
            (new TFoot)
            ->setComponents([
                (new OneCellRow)
                ->setComponents([
                    new Pager,
                    (new HtmlTag)
                    ->setAttributes(['class' => 'pull-right'])
                    ->addComponent(new ShowingRecords)
                        ,
                ])
            ])
        ])
    );

    if (isset($_GET['Models']) && (isset($_GET['Models']['csv']) || isset($_GET['Models']['xls']))) {
      return $grid;
    }

    return view('widgets.performer_stats', [
      'grid' => $grid
    ]);
  }

}
