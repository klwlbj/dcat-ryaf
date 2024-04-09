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
                <div class="header font-weight weui-flex">
                    <div class="back-icon back-page"><i class="weui-icon-back weui-icon_msg color-white"></i></div>
                    <div class="weui-flex__item">出租屋-消防检查</div>
                    <button type="button" class="weui-btn weui-btn_mini weui-btn_warn edit-icon open-popup"
                            title="新增单位信息(*号为必填)" data-target="enterprise-add">新增
                    </button>
                </div>
                <div class="weui-search-bar" id="searchBar">
                    <form id="search" aria-haspopup="true" aria-expanded="false" aria-owns="searchResult"
                          class="weui-search-bar__form">
                        <div class="weui-search-bar__box">
                            <i class="weui-icon-search"></i>
                            <input type="search" aria-controls="searchResult" class="weui-search-bar__input"
                                   id="searchInput" placeholder="输入关键词再按回车确定" required="">
                            <a href="javascript:" role="button" title="清除" class="weui-icon-clear" id="searchClear"
                               wah-hotarea="touchend"></a>
                        </div>
                        <label for="searchInput" class="weui-search-bar__label" id="searchText" wah-hotarea="touchend"
                               style="transform-origin: 0 0; opacity: 1; transform: scale(1, 1);">
                            <i class="weui-icon-search"></i>
                            <span aria-hidden="true">搜索</span>
                        </label>
                    </form>
                    <button class="weui-search-bar__cancel-btn" id="searchCancel" wah-hotarea="touchend">取消</button>
                </div>
                <div class="weui-tab__panel">
                    <div class="weui-cells dis" id="enterpriseListTpl">
                        @{{# layui.each(d, function(index, item){ }}
                        <a class="weui-cell weui-cell_access" href="/web/enterpriseInfo?number=@{{ item.number }}">
<span class="weui-cell__bd">
<span>@{{ item.enterpriseName }}</span>
<div class="weui-cell__desc">@{{ item.address }}</div>
</span>
                            <span class="weui-cell__ft">@{{ item.number }}</span>
                        </a>
                        @{{# }); }}
                        @{{# if(d.length === 0){ }}
                        <p class="text-center color-gray fsize12">无数据</p>
                        @{{# } }}
                    </div>
                </div>
            </div>
            <div class="weui-tabbar fcms-footer">
                <a href="../index/" class="weui-tabbar__item weui-bar__item_on">
                    <img src="https://cdn.qiping.cn/fcms/mobile/images/ico-home.png" class="weui-tabbar__icon">
                </a>
                <a href="../enterprise/index" class="weui-tabbar__item">
                    <img src="https://cdn.qiping.cn/fcms/mobile/images/ico-work.png" class="weui-tabbar__icon">
                </a>
                <a href="../index/user" class="weui-tabbar__item">
                    <img src="https://cdn.qiping.cn/fcms/mobile/images/ico-user.png" class="weui-tabbar__icon">
                </a>
            </div>
        </div>
    </div>
</div>
<div class="weui-form ptop5 dis" id="enterprise-add">
    <div class="weui-form__control-area mtop5">
        <div class="weui-cells__group weui-cells__group_form">
            <form id="form" aria-haspopup="true" aria-expanded="false">
                <div class="weui-cells">
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><span class="weui-label">单位名称<i class="color-red">*</i></span>
                        </div>
                        <div class="weui-cell__bd">
                            <input type="text" required class="weui-input fms-input fms-border" maxlength="50"
                                   name="enterpriseName" placeholder="输入单位名称">
                        </div>
                    </div>
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><span class="weui-label">负责人</span></div>
                        <div class="weui-cell__bd">
                            <input type="text" class="weui-input fms-input fms-border" maxlength="15" name="manager"
                                   placeholder="输入负责人姓名">
                        </div>
                    </div>
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><span class="weui-label">联系方式</span></div>
                        <div class="weui-cell__bd">
                            <input type="text" class="weui-input fms-input fms-border" maxlength="20" name="phone"
                                   placeholder="输入联系号码">
                        </div>
                    </div>
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><span class="weui-label">社区名称</span></div>
                        <div class="weui-cell__bd">
                            <input type="text" class="weui-input fms-input fms-border" maxlength="50" name="community"
                                   placeholder="输入社区名称">
                            <p>
                                <select class="weui-select fms-select fms-border minheight30" id="communityList">
                                    <option value="">---选择社区---</option>
                                    @{{# layui.each(d, function(index, item){ }}
                                    <option value="@{{ item }}">@{{ item }}</option>
                                    @{{# }); }}
                                </select>
                            </p>
                        </div>
                    </div>
                    <label for="checkTypeID" class="weui-cell weui-cell_active weui-cell_select weui-cell_select-after">
                        <div class="weui-cell__hd">
                            <span class="weui-label">检查类型<i class="color-red">*</i></span>
                        </div>
                        <div class="weui-cell__bd">
                            <select class="weui-select fms-select" required name="checkTypeID" id="checkTypeID"
                                    placeholder="请选择检查类型">
                                <option>--选择检查类型--</option>
                                @{{# layui.each(d, function(index, item){ }}
                                <option value="@{{ item.id }}">@{{ item.name }}</option>
                                @{{# }); }}
                            </select>
                        </div>
                    </label>
                    <label for="checkStatusID"
                           class="weui-cell weui-cell_active weui-cell_select weui-cell_select-after">
                        <div class="weui-cell__hd">
                            <span class="weui-label">检查状态</span>
                        </div>
                        <div class="weui-cell__bd">
                            <select class="weui-select fms-select" name="checkStatusID" id="checkStatusID">
                                @{{# layui.each(d, function(index, item){ }}
                                <option value="@{{ item.id }}">@{{ item.name }}</option>
                                @{{# }); }}
                            </select>
                        </div>
                    </label>
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><span class="weui-label">楼层/面积</span></div>
                        <div class="weui-cell__bd color-gray">
                            <input type="tel" style="width:20%;" class="weui-input fms-input fms-border" maxlength="10"
                                   name="floorNum" placeholder="楼层">
                            <input type="tel" style="width:40%;" class="weui-input fms-input fms-border" maxlength="10"
                                   name="businessArea" placeholder="面积">（m²）
                        </div>
                    </div>
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><span class="weui-label">单位地址<i class="color-red">*</i></span>
                        </div>
                        <div class="weui-cell__bd">
                            <input type="text" required class="weui-input fms-input fms-border" maxlength="100"
                                   name="address" placeholder="输入单位地址">
                        </div>
                    </div>
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><span class="weui-label">备注</span></div>
                        <div class="weui-cell__bd">
                            <input type="text" class="weui-input fms-input fms-border" maxlength="255" name="remake"
                                   placeholder="输入其它说明">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="weui-form__tips-area">
        <p class="weui-form__tips color-red">
        </p>
    </div>
    <div class="weui-half-screen-dialog__ft">
        <button class="weui-btn weui-btn_primary" id="save">保存</button>
        <button class="weui-btn weui-btn_default close-popup">关闭</button>
    </div>
</div>
<!--end-->
<script>const typeId = '3';</script>
<script src="{{ asset('js/enterpriseList.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/addEnterprise.js') }}" charset="utf-8"></script>
</body>
</html>
