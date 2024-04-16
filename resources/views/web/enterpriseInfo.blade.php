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
                    <div class="weui-flex__item">排查单位详情</div>
                    <button type="button" class="weui-btn weui-btn_mini weui-btn_warn edit-icon edit">编辑</button>
                </div>
                <div class="weui-form ptop5 pbottom10 dis" id="enterprise-edit">
                    <div class="weui-form__control-area mtop5">
                        <div class="weui-cells__group weui-cells__group_form">
                            <form id="form" aria-haspopup="true" aria-expanded="false">
                                <input type="hidden" name="uuid" value="@{{ d.enterprise.uuid }}">
                                <div class="weui-cells">
                                    <div class="weui-cell">
                                        <div class="weui-cell__hd"><span class="weui-label">编号</span></div>
                                        <div class="weui-cell__bd color-gray">@{{ d.enterprise.number }}</div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__hd"><span class="weui-label">单位名称<i
                                                    class="color-red">*</i></span></div>
                                        <div class="weui-cell__bd">
                                            <input type="text" class="weui-input fms-input" required
                                                   name="enterpriseName" maxlength="50" placeholder="输入单位名称"
                                                   disabled value="@{{ d.enterprise.enterpriseName }}">
                                        </div>
                                    </div>
                                    <label for="checkStatusID"
                                           class="weui-cell weui-cell_active weui-cell_select weui-cell_select-after">
                                        <div class="weui-cell__hd">
                                            <span class="weui-label">检查状态<i class="color-red">*</i></span>
                                        </div>
                                        <div class="weui-cell__bd">
                                            <select class="weui-select fms-select" name="checkStatusID"
                                                    id="checkStatusID" disabled>
                                                @{{# layui.each(d.csList, function(index, item){ }}
                                                <option value="@{{ item.id }}">@{{ item.name }}</option>
                                                @{{# }); }}
                                            </select>
                                            <script>$("#checkStatusID").val('@{{  d.enterprise.checkStatusID }}')</script>
                                        </div>
                                    </label>
                                    <label for="checkResult"
                                           class="weui-cell weui-cell_active weui-cell_select weui-cell_select-after">
                                        <div class="weui-cell__hd">
                                            <span class="weui-label">检查结果</span>
                                        </div>
                                        <div class="weui-cell__bd">
                                            <select class="weui-select fms-select" name="checkResult" id="checkResult"
                                                    placeholder="请选择检查结果" disabled>
                                                <option value=""></option>
                                                <option value="合格">合格</option>
                                                <option value="不合格">不合格</option>
                                            </select>
                                            <script>$("#checkResult").val('@{{  d.enterprise.checkResult }}')</script>
                                        </div>
                                    </label>
                                    <div class="weui-cell">
                                        <div class="weui-cell__hd"><span class="weui-label">负责人</span></div>
                                        <div class="weui-cell__bd">
                                            <input type="text" class="weui-input fms-input" maxlength="15"
                                                   name="manager" placeholder="输入负责人姓名" disabled
                                                   value="@{{ d.enterprise.manager }}">
                                        </div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__hd"><span class="weui-label">联系方式</span></div>
                                        <div class="weui-cell__bd">
                                            <input type="text" class="weui-input fms-input" maxlength="20" name="phone"
                                                   placeholder="输入联系号码" disabled
                                                   value="@{{ d.enterprise.phoneFull }}">
                                        </div>
                                    </div>
                                    <label for="checkTypeID"
                                           class="weui-cell weui-cell_active weui-cell_select weui-cell_select-after">
                                        <div class="weui-cell__hd">
                                            <span class="weui-label">检查类型<i class="color-red">*</i></span>
                                        </div>
                                        <div class="weui-cell__bd">
                                            <select class="weui-select fms-select" name="checkTypeID" id="checkTypeID"
                                                    placeholder="请选择检查类型" disabled>
                                                @{{# layui.each(d.ctList, function(index, item){ }}
                                                <option value="@{{ item.id }}">@{{ item.name }}</option>
                                                @{{# }); }}
                                            </select>
                                            <script>$("#checkTypeID").val('@{{  d.enterprise.checkTypeID }}')</script>
                                        </div>
                                    </label>
                                    <label for="community"
                                           class="weui-cell weui-cell_active weui-cell_select weui-cell_select-after">
                                        <div class="weui-cell__hd">
                                            <span class="weui-label">网格社区</span>
                                        </div>
                                        <div class="weui-cell__bd">
                                            <select class="weui-select fms-select" name="community" id="community"
                                                    placeholder="请选择社区" disabled>
                                                @{{# layui.each(d.coList, function(index, item){ }}
                                                <option value="@{{ item }}">@{{ item }}</option>
                                                @{{# }); }}
                                            </select>
                                            <script>$("#community").val('@{{  d.enterprise.community }}')</script>
                                        </div>
                                    </label>
                                    <div class="weui-cell">
                                        <div class="weui-cell__hd"><span class="weui-label">楼层/面积</span></div>
                                        <div class="weui-cell__bd color-gray">
                                            <input type="tel" style="width:20%;" class="weui-input fms-input"
                                                   maxlength="10" name="floorNum" placeholder="楼层" disabled
                                                   value="@{{ d.enterprise.floorNum }}">/
                                            <input type="tel" style="width:40%;" class="weui-input fms-input"
                                                   maxlength="10" name="businessArea" placeholder="面积" disabled
                                                   value="@{{ d.enterprise.businessArea }}">（m²）
                                        </div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__hd"><span class="weui-label">单位地址<i
                                                    class="color-red">*</i></span></div>
                                        <div class="weui-cell__bd">
                                            <input type="text" required class="weui-input fms-input" name="address"
                                                   placeholder="输入单位地址" disabled
                                                   value="@{{ d.enterprise.address }}">
                                        </div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__hd"><span class="weui-label">备注说明</span></div>
                                        <div class="weui-cell__bd">
                                            <input type="text" class="weui-input fms-input" name="remark"
                                                   placeholder="输入其它说明" disabled
                                                   value="@{{ d.enterprise.remark }}">
                                        </div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__hd"><span class="weui-label">采集信息</span></div>
                                        <div class="weui-cell__bd">
                                            <img src="https://cdn.qiping.cn/fcms/mobile/images/camera.png" width="35"
                                                 height="30" class="open-popup-iframe"
                                                 data-target="/web/collectInfo?uuid=@{{ d.enterprise.uuid }}&checkTypeID=@{{ d.enterprise.checkTypeID }}"
                                                 title="采集信息"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="weui-btn-area mbottom20">
                        <button type="button" class="weui-btn weui-btn_primary" id="newCheckBtn">全新检查</button>
                        <button type="button" class="weui-btn weui-btn_primary fms-bg-blue" id="reCheckBtn">复 检
                        </button>
                        <button type="button" class="weui-btn weui-btn_warn open-popup" title="中止检查原因"
                                data-target="#stopCheck">中止检查
                        </button>
                    </div>
                </div>
            </div>
            <div class="weui-tabbar fcms-footer">
                @include('..include/footer')
            </div>
        </div>
    </div>
</div>
<div id="stopCheck" class="weui-popup__container dis">
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal">
        <div class="weui-flex">
            <div class="weui-flex__item placeholder">
                <button class="weui-btn weui-btn_primary stopCheckSave">确 定</button>
            </div>
        </div>
        <div class="weui-cells weui-cells_radio">
            @{{# layui.each(d, function(index, item){ }}
            <label class="weui-cell weui-check__label" for="s@{{ item.id }}">
                <div class="weui-cell__bd">
                    <p>@{{ item.name }} @{{# if(item.orderBy == 0) { }}<span
                            class="color-red mlet10 fsize12">选择此项可取消中止</span>@{{# }}}</p>
                </div>
                <div class="weui-cell__ft">
                    <input type="radio" class="weui-check" name="csid" id="s@{{ item.id }}" refName="@{{ item.name }}"
                           orderBy="@{{ item.orderBy }}" value="@{{ item.id }}">
                    <span class="weui-icon-checked"></span>
                </div>
            </label>
            @{{# }); }}
        </div>
        <br><br><br>
    </div>
</div>
<script>const uuid = "{{$uuid}}";
    const reportCode = "{{$reportCode}}";
    const isCheck = "true";
</script>
<script src="{{ asset('js/enterprise.js') }}" charset="utf-8"></script>
</body>
</html>
