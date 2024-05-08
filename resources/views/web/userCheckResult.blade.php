<!DOCTYPE html>
<html>
<head>
    @include('..include/head')
</head>
<body ontouchstart="">
<div class="container" id="container">
    <div class="page__bd" style="height: 100%;">
        <div class="weui-tab">
            <div class="weui-tab__panel">
                <div class="weui-search-bar" id="searchBar">
                    <form id="search" aria-haspopup="true" aria-expanded="false" aria-owns="searchResult"
                          class="weui-search-bar__form">
                        <div class="weui-search-bar__box">
                            <i class="weui-icon-search"></i>
                            <input type="search" aria-controls="searchResult" class="weui-search-bar__input"
                                   id="searchInput" placeholder="选择日期" required="">
                            <a href="javascript:" role="button" title="清除" class="weui-icon-clear" id="searchClear"
                               wah-hotarea="touchend"></a>
                        </div>
                        <label for="searchInput" class="weui-search-bar__label" id="searchText" wah-hotarea="touchend"
                               style="transform-origin: 0 0; opacity: 1; transform: scale(1, 1);">
                            <i class="weui-icon-search"></i>
                            <span aria-hidden="true">选择日期</span>
                        </label>
                    </form>
                    <button class="weui-search-bar__cancel-btn" id="searchCancel" wah-hotarea="touchend">取消</button>
                </div>
                <div class="weui-cells dis" id="checkResult">
                    @{{# layui.each(d, function(index, item){ }}
                    <a class="weui-cell weui-cell_access"
                       href="/web/enterpriseInfo?uuid=@{{ item.enterpriseUuid }}">
                        <div class="weui-cell__bd"><p>@{{ item.enterpriseName }}</p></div>
                        <div class="weui-cell__ft"> @{{ getLocalTime(item.reportTime) }}</div>
                    </a>
                    @{{# }); }}
                </div>
            </div>
            <div class="weui-tabbar fcms-footer">
                @include('..include/footer')
            </div>
        </div>
    </div>
</div>
<script>
    const checkUser = "{{$phone}}";
    const data = {"checkUser": checkUser};
</script>
<script src="{{ asset('js/iScroll.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/Mdate.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/userCheckResult.js') }}" charset="utf-8"></script>
</body>
</html>
