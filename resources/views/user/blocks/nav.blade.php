<div id="categorymenu">
    <nav class="subnav">
        <ul class="nav-pills categorymenu"><!-- nav navbar-nav -->
            <li><a class="{{ Request::is('/') ? 'active' : '' }}" href="{!! URL('/') !!}"><i class="glyphicon glyphicon-home"></i></a></li>
            
            <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="glyphicon glyphicon-list">&nbsp;</span>Danh mục sản phẩm</a>
                <ul class="dropdown-menu multi-level">
                <?php
                $menu_level_1 = DB::table('cates')
                    ->where('parent_id', 0)
                    ->get();
                ?>
                @if(count($menu_level_1) > 0)
                @foreach ($menu_level_1 as $item_lv_1)
                    
                    <li class="dropdown-submenu"><a href="{!! Route('category_page', [$item_lv_1->alias]) !!}">{!! $item_lv_1->name !!}</a>
                        <ul class="dropdown-menu set-frame">
                        <?php
                        $menu_level_2 = DB::table('cates')
                            ->where('parent_id', $item_lv_1->id)
                            ->get();
                        ?>
                        @if($menu_level_2)
                        @foreach ($menu_level_2 as $item_lv_2)
                            <li class="col-1"><a href="{!! Route('product_page', [$item_lv_1->alias, $item_lv_2->alias,]) !!}"><span><strong> {!! $item_lv_2->name !!}</strong></a> </span>
                                <div class="col-md-12 " style=""> 
                                    <ul class="col-2">
                                    <?php
                                    $menu_level_3 = DB::table('cates')
                                       ->where('parent_id', $item_lv_2->id)
                                       ->get();
                                    ?>
                                    @if($menu_level_3)
                                    @foreach ($menu_level_3 as $item_lv_3)
                                        <div class=""> 
                                        <li class=""><a href="{!! Route('sections_page', [$item_lv_1->alias, $item_lv_2->alias, $item_lv_3->alias]) !!}">{!! $item_lv_3->name !!}</a>
                                        </li>
                                        </div>
                                    @endforeach
                                    @endif
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                        @endif
                        </ul>
                    </li>
                @endforeach
                @endif
                </ul>
            </li>
            <li><a href="{!! URL('dien-dan') !!}">Diễn đàn</a></li>
            <li><a class="{{ Request::is('lien-he') ? 'active' : '' }}" href="{!! URL('lien-he') !!}">Liên hệ</a></li>
            <li class="pull-right">
                <form class="navbar-form" role="search" action="{!! route('search') !!}">
                    <input type="text" class="form-control" placeholder="Search" name="k" id="srch-term" value="<?php echo isset($_GET['k']) ? $_GET['k'] : null; ?>">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </form>
            </li>
        </ul>
    </nav>
</div>