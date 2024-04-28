{!! admin_js(['statics/js/vue.js','statics/js/element.js','statics/js/httpVueLoader.js','statics/js/axios.min.js']) !!}
{!! admin_css(['statics/css/element.css']) !!}


<div id="app">
    <el-card class="box-card" v-loading="loading">
        <el-descriptions :column="2" border>
            <el-descriptions-item label="单位">@{{ info.company_name }}</el-descriptions-item>
            <el-descriptions-item label="编号">@{{ info.number }}</el-descriptions-item>
            <el-descriptions-item label="检查状态">@{{ info.check_status }}</el-descriptions-item>
            <el-descriptions-item label="检查结果">@{{ info.result }}</el-descriptions-item>
            <el-descriptions-item label="检查人">@{{ info.check_user_name }}</el-descriptions-item>
            <el-descriptions-item label="检查时间">@{{ info.check_date }}</el-descriptions-item>
            <el-descriptions-item label="检查得分">@{{ info.check_score }}</el-descriptions-item>
            <el-descriptions-item label="扣分">@{{ info.deduction }}</el-descriptions-item>
            <el-descriptions-item label="隐患数" :span="2">@{{ info.hidden_danger_count }}</el-descriptions-item>
            <el-descriptions-item label="地址" :span="2">@{{ info.address }}</el-descriptions-item>
            <el-descriptions-item label="采集图片" :span="2">
                <div v-if="info.image_list">
                    <el-image
                        v-for="item in info.image_list"
                        v-on:click="imagePreview([item])"
                        style="width: 100px; height: 100px"
                        :src="item"
                        fit="contain"></el-image>
                </div>
            </el-descriptions-item>
            <el-descriptions-item label="二维码" :span="2">
                <div v-if="info.qrcode_url">
                    <el-image
                        style="width: 100px; height: 100px"
                        :src="info.qrcode_url"
                        fit="contain"></el-image>
                </div>
            </el-descriptions-item>
        </el-descriptions>



    </el-card>

    <el-card style="margin-top: 20px" v-loading="loading">
        <template>
            <el-table
                :data="list"
                style="width: 100%">


                <el-table-column
                    prop="project_name"
                    align="center"
                    label="检查项目"
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="standard"
                    label="检查标准"
                    width="300">

                </el-table-column>
                <el-table-column
                    prop="is_rectify"
                    label="是否需整改"
                    width="180">
                    <template slot-scope="scope">
                        <div>
                            <el-tag v-if="scope.row.is_rectify == 0" size="small" style="background-color: #1E9FFF !important;color: white">无需整改</el-tag>
                            <el-tag v-if="scope.row.is_rectify == 1" size="small" style="background-color: #FF5722 !important;color: white">需整改</el-tag>
                        </div>
                        <div v-if="scope.row.deduction > 0">
                            <el-tag size="small" style="background-color: #FFB800!important;color: white">扣@{{ scope.row.deduction }}分</el-tag>
                        </div>
                    </template>
                </el-table-column>

                <el-table-column
                    prop="standard_problem"
                    label="标准问题"
                    width="180">
                </el-table-column>

                <el-table-column
                    prop="measure"
                    label="整改措施"
                    width="180">

                    <template slot-scope="scope">
                        <div>
                            @{{scope.row.measure}}
                        </div>
                        <div v-if="scope.row.difficulty != ''">
                            <el-tag size="small" style="background-color: #FF5722!important;color: white">整改:@{{ scope.row.difficulty }}</el-tag>
                        </div>

                        <div v-if="scope.row.imageList.length > 0">
                            <el-button size="small" style="background-color: #FFB800 !important;color: white" v-on:click="imagePreview(scope.row.imageList)">查看隐患图</el-button>
                        </div>


                    </template>
                </el-table-column>

            </el-table>
        </template>
    </el-card>
    <el-image
        ref="imagePreview"
        style="width: 0; height: 0"
        :src="imageFirst"
        :preview-src-list="imageList">
    </el-image>
</div>

<script>
    Vue.use(httpVueLoader)

    new Vue({
        el: '#app',
        data: {
            info:{
                company_name:'',
                number:'',
                check_status:'',
                result:'',
                check_user_name:'',
                check_date:'',
                check_score:'',
                deduction:'',
                hidden_danger_count:'',
                address:'',
                image_list:'',
            },
            list:[],
            loading:false,
            total:0,
            imageFirst:'',
            imageList:[],
            id:null,
        },
        components: {

        },
        created(){
            this.id = this.getQuery('id');
            this.getInfo();
        },
        methods: {
            getQuery(name){
                let reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
                let r = window.location.search.substr(1).match(reg);
                if (r != null) return unescape(r[2]); return null;
            },
            imagePreview(list){
                let that = this;
                this.$nextTick(() => {
                    that.imageList = list;
                    that.imageFirst = list[0];
                    that.$refs['imagePreview'].showViewer = true;
                });

            },
            getInfo(){
                let that = this;
                that.loading = true;
                axios({
                    // 默认请求方式为get
                    method: 'post',
                    url: '/admin/check_report/info',
                    // 传递参数
                    data: {
                        id:this.id,
                        is_qr:1
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
                    that.info = res['data']['info'];
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
