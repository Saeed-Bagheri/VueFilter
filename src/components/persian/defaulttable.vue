<template>


    <div class="vue-filter-container">
        <div class="vue-filter-content">

            <filterable v-bind="filterable"  class="vue-filter-component" >

                <thead slot="thead">

                <tr >

                    <th>نام</th>
                    <th>پست الکترونیک</th>
                    <th>تاریخ ثبت نام</th>



                </tr>
                </thead>
                <tr slot-scope="{item}">

                    <td>{{item.name}}</td>
                    <td>{{item.email}}</td>
                    <td>{{item.created_at}}</td>


                </tr>


            </filterable>

        </div>
    </div>


</template>

<script type="text/javascript">

    import Filterable from './filter.vue'

    export default {
        components: {Filterable},

        props: {

            getdataurl: {
                type: String,
                required: true
            }
        },


        data() {
            return {

                filterable: {
                    url: this.getdataurl,
                    order_by: 'created_at',
                    orderables: [
                        {title: 'نام', name: 'name'},
                        {title: 'پست الکترونیک', name: 'email'},
                        {title: 'تاریخ ثبت نام', name: 'created_at'},


                    ],
                    filterGroups: [
                        {
                            filters: [
                                {title: 'نام', name: 'name', type: 'string'},
                                {title: 'پست الکترونیک', name: 'email', type: 'string'},
                                {title: 'تاریخ ثبت نام', name: 'created_at', type: 'datetime'},
                            ]

                        }
                    ]
                }
            }
        },




    }
</script>

