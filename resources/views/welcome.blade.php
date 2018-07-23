<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Index</title>
    <link rel="stylesheet" href="{{asset('css/boostrap.min.css')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script src="{{asset('js/jquery.min.js')}}"></script>
</head>

<body>
    <div class="container my-4" id="items-table">
        <table class="table table-bordered table-condensed text-center">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody v-if="items != null" v-for="item in items">
                <tr v-if="item.id == edited_id">
                    <td>
                        <input class="form-control"
                            v-model="item.name"
                            v-bind:id="'name'+item.id"
                            type="text"
                            name="name"
                            placeholder="Name">
                    </td>
                    <td>
                        <input class="form-control"
                            v-model="item.category"
                            v-bind:id="'category'+item.id"
                            type="text"
                            name="category"
                            placeholder="Category">
                    </td>
                    <td>
                        <input class="form-control"
                            v-model="item.price"
                            v-bind:id="'price'+item.id"
                            type="number"
                            name="price"
                            placeholder="Price">
                    </td>
                    <td>
                        <button class="btn btn-success" @click="updateData(item)"><i class="fa fa-check"></i></button>
                        <button class="btn btn-default" @click="showEditForm(0)"><i class="fa fa-times"></i></button>
                    </td>
                </tr>
                <tr v-else>
                    <td>@{{ item.name }}</td>
                    <td>@{{ item.category }}</td>
                    <td>@{{ item.price }}</td>
                    <td>
                        <button class="btn btn-warning" @click="showEditForm(item.id)"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger" @click="deleteData(item)"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <input class="form-control"
                            v-model="item.name"
                            type="text"
                            name="name"
                            placeholder="Name">
                    </td>
                    <td>
                        <input class="form-control"
                            v-model="item.category"
                            type="text"
                            name="category"
                            placeholder="Category">
                    </td>
                    <td>
                        <input class="form-control"
                            v-model="item.price"
                            type="number"
                            name="price"
                            placeholder="Price">
                    </td>
                    <td>
                        <button class="btn btn-success" @click="insertData"><i class="fa fa-plus"></i> &nbsp;Add</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
<script type="text/javascript">
    var app = new Vue({
        el: '#items-table',
        mounted() {
            this.fetchData();
            this.clearColumn();
        },
        data: {
            edited_id: 0,
            items: [],
            item: {
                id: '',
                name: '',
                category:'',
                price:'',
            },
            base_url: window.location.origin,
        },
        methods: {
            fetchData() {
                axios.get(this.base_url+'/items')
                .then(response => {
                    this.items = response.data;
                });
            },
            insertData () {
                axios.post(this.base_url+'/items', this.item)
                     .then((res) => {
                         this.fetchData();
                         this.clearColumn();
                     })
                     .catch((err) => {
                         console.log(err);
                     });
            },
            showEditForm(id) {
                this.fetchData();
                this.edited_id = id;
                console.log("Edited id: "+this.edited_id);
            },
            updateData (item) {
                console.log("update untuk id : "+item.id+" nama mobil : "+item.name);
                axios.put(this.base_url+`/items/${item.id}`,{
                    name : item.name,
                    category: item.category,
                    price: item.price,
                })
                     .then((res) => {
                         this.edited_id = 0;
                         this.fetchData();
                     })
                     .catch((err) => {
                         console.log(err);
                     });
            },
            deleteData (item) {
                axios.delete(this.base_url+`/items/${item.id}`)
                     .then((res) => {
                         this.fetchData();
                     })
                     .catch((err) => {
                         console.log(err);
                     });
                console.log("delete");
            },
            clearColumn() {
                this.item.name = '';
                this.item.category = '';
                this.item.price = '';
            }
        }
    });
</script>
