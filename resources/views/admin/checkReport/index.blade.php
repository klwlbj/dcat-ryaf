{!! admin_js(['statics/js/vue.js','statics/js/element.js','statics/js/httpVueLoader.js','statics/js/axios.min.js']) !!}
{!! admin_css(['statics/css/element.css']) !!}


<div id="app">
    <el-card class="box-card">
        <el-form :inline="true" :model="form" class="demo-form-inline">
            <el-form-item>
                <el-select v-model="value" placeholder="请选择"></el-select>
            </el-form-item>
            <el-form-item>
                <el-input v-model="input" placeholder="企业名称|编号|检查员"></el-input>
            </el-form-item>
            <el-form-item>
                <el-select v-model="value" placeholder="选择检查类型"></el-select>
            </el-form-item>
            <el-form-item>
                <el-select v-model="value" placeholder="选择社区"></el-select>
            </el-form-item>
            <el-form-item>
                <el-select v-model="value" placeholder="选择企业状态"></el-select>
            </el-form-item>
            <el-form-item>
                <el-select v-model="value" placeholder="检查开始时间"></el-select>
            </el-form-item>
            <el-form-item>
                <el-select v-model="value" placeholder="检查截至时间"></el-select>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="el-icon-search" v-on:click="getList">搜索</el-button>
            </el-form-item>
            <el-form-item>
                <el-button icon="el-icon-arrow-up" style="background-color: #2F4056 !important;color:white">导出当前搜索隐患数据</el-button>
            </el-form-item>
        </el-form>

        <div>
            <el-button icon="el-icon-arrow-up" style="background-color: #FF5722 !important;color:white">导出当前项目隐患数据</el-button>
        </div>
        <template>
            <el-table
                v-loading="loading"
                :data="list"
                style="width: 100%">


                <el-table-column
                    prop="id"
                    label="序号"
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="report"
                    label="检查报告"
                    width="180">
                    <template slot-scope="scope">
                        <el-link :href="'/admin/check_report/detail?id='+scope.row.id" target="_blank">报告详情</el-link>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="rectify"
                    label="整改告知书"
                    width="200">
                    <template slot-scope="scope">
                        <el-button type="success" v-on:click="rectifyBook(scope.row)">整改通知书</el-button>
                    </template>
                </el-table-column>

                <el-table-column
                    prop="result"
                    label="检查结果"
                    width="180">
                </el-table-column>

                <el-table-column
                    prop="sn"
                    label="自定义编号"
                    width="180">
                </el-table-column>

                <el-table-column
                    prop="company_name"
                    label="企业名称"
                    width="180">
                </el-table-column>

                <el-table-column
                    prop="address"
                    label="地址"
                    width="180">
                </el-table-column>
            </el-table>
        </template>
        <div style="margin-top: 10px">
            <el-pagination
                background
                layout="prev, pager, next"
                :total="total">
            </el-pagination>
        </div>

    </el-card>


</div>

<script>
    Vue.use(httpVueLoader)

    new Vue({
        el: '#app',
        data: {
            list:[],
            loading:false,
            total:0,
            form:{

            }
        },
        components: {

        },
        created(){
            this.getList();
        },
        methods: {
            search(){

            },
            rectifyBook(row){
                window.location.href = '/admin/check_report/create_rectify_word?id=' + row.id;
            },
            getList(){

                let that = this;
                that.loading = true;
                axios({
                    // 默认请求方式为get
                    method: 'post',
                    url: '/admin/check_report/lists',
                    // 传递参数
                    data: {

                    },
                    responseType: 'json',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                }).then(res => {
                    res = res.data
                    that.loading = false;
                    if (res['code'] != 0) {
                        that.$message.error(res['message']);
                        return false;
                    }
                    that.list = res['data']['list'];
                    that.total = res['data']['total'];
                }).catch(error => {
                    that.loading = false;
                    that.$message.error('请求失败');
                });
            }
        },
        mounted:function(){

        }
    })
</script>
