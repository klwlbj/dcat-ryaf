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
                    <div class="weui-flex__item">基础信息</div>
                    {{--<button type="button" class="weui-btn weui-btn_mini weui-btn_warn edit-icon open-popup-full"
                            title="新增单位信息(*号为必填)" data-target="enterprise-add">新增
                    </button>--}}
                </div>
                <div class="weui-search-bar" id="searchBar">
                    <form id="search" aria-haspopup="true" aria-expanded="false" aria-owns="searchResult"
                          class="weui-search-bar__form">
                        <div class="weui-search-bar__box">
                            <i class="weui-icon-search"></i>
                            <input type="search" aria-controls="searchResult" class="weui-search-bar__input"
                                   id="searchInput" placeholder="输入关键词再按回车确定" >
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
                <div class="weui-tab" id="tab">
                    <div class="weui-navbar">
                        <div role="tab" aria-selected="true" aria-controls="panel1"
                             class="weui-navbar__item weui-bar__item_on" wah-hotarea="touchend">
                            单位信息
                        </div>
                        <div role="tab" aria-controls="panel2" class="weui-navbar__item" wah-hotarea="touchend"
                             aria-selected="false">
                            排查人员
                        </div>
                    </div>
                    <div class="weui-tab__panel">
                        <div role="tabpanel" class="weui-tab__content">
                            <div class="weui-cells dis" id="enterpriseListTpl">
                                @{{# layui.each(d.list, function(index, item){ }}
                                <div class="weui-cell weui-cell_access open-popup" uuid="@{{ item.uuid }}"
                                     title="单位信息详情" data-target="enterprise-show">
                                    <span class="weui-cell__bd">
                                    <span>@{{ item.enterpriseName }}</span>
                                    <div class="weui-cell__desc">@{{ item.address }}</div>
                                    </span>
                                    <span class="weui-cell__ft">@{{ item.number }}</span>
                                </div>
                                @{{# }); }}
                                @{{# if(d.list.length === 0){ }}
                                <p class="text-center color-gray fsize12">无数据</p>
                                @{{# } }}
                            </div>
                        </div>
                        <div role="tabpanel" class="weui-tab__content dis">
                            <div class="weui-cells dis" id="userListTpl">
                                @{{# layui.each(d.list, function(index, item){ }}
                                <div class="weui-cell weui-cell_access open-popup" uuid="@{{ item.uuid }}"
                                     title="人员信息详情" data-target="user-show">
                                    <div class="weui-cell__bd"><p>@{{ item.fullName }}</p></div>
                                    <div class="weui-cell__ft">@{{ item.phone }}</div>
                                </div>
                                @{{# }); }}
                                @{{# if(d.list.length === 0){ }}
                                <p class="text-center color-gray fsize12">无数据</p>
                                @{{# } }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="weui-tabbar fcms-footer">
                @include('..include/footer')
            </div>
        </div>
    </div>
</div>
<div class="weui-form ptop5 dis" id="enterprise-show">
    <div class="weui-form__control-area mtopbottom5">
        <div class="weui-cells__group weui-cells__group_form" id="enterpriseInfo">
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">单位名称</span></div>
                    <div class="weui-cell__bd">@{{ d.enterpriseName }}</div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">检查状态</span></div>
                    <div class="weui-cell__bd">@{{ d.checkStatusName }}</div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">负责人</span></div>
                    <div class="weui-cell__bd">@{{ d.manager }}</div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">联系方式</span></div>
                    <div class="weui-cell__bd">
                        <a href="tel:@{{ d.phone }}">@{{ d.phone }}</a>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">检查类型</span></div>
                    <div class="weui-cell__bd">@{{ d.checkTypeName }}</div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">网格社区</span></div>
                    <div class="weui-cell__bd">@{{ d.community }}</div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">楼层/面积</span></div>
                    <div class="weui-cell__bd">@{{ d.floorNum }}/@{{ d.businessArea }}(m²)</div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">企业地址</span></div>
                    <div class="weui-cell__bd">@{{ d.address }}</div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">所属项目</span></div>
                    <div class="weui-cell__bd">@{{ d.projectName }}</div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">备注</span></div>
                    <div class="weui-cell__bd">@{{ d.remark }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end-->
<div class="weui-form ptop5 dis" id="user-show">
    <div class="weui-form__control-area mtop5">
        <div class="weui-cells__group weui-cells__group_form" id="userInfo">
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">姓 名</span></div>
                    <div class="weui-cell__bd">@{{ d.fullName }}</div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">联系方式</span></div>
                    <div class="weui-cell__bd">
                        <a href="tel:@{{ d.phone }}">@{{ d.phone }}</a>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">岗位信息</span></div>
                    <div class="weui-cell__bd">@{{ d.jobInfo }}</div>
                </div>
                {{--<div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">账户类型</span></div>
                    <div class="weui-cell__bd">@{{ d.userType }}</div>
                </div>--}}
                {{--<div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">账户分组</span></div>
                    <div class="weui-cell__bd">@{{ d.userGroup }}</div>
                </div>--}}
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">邮箱</span></div>
                    <div class="weui-cell__bd">@{{ d.email }}</div>
                </div>
                {{--<div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label font-weight">Q Q</span></div>
                    <div class="weui-cell__bd">@{{ d.qq }}</div>
                </div>--}}
            </div>
        </div>
    </div>
</div>
<!--end-->
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
                            <input type="text" class="weui-input fms-input fms-border" maxlength="255" name="remark"
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
<script src="{{ asset('js/baseInfo.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/addEnterprise.js') }}" charset="utf-8"></script>
</body>
</html>
