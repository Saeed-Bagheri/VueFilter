<template>


    <div class="vue-filter-container">
        <div class="vue-filter-content">

            <filterable v-bind="filterable" class="vue-filter-component" >

                <thead slot="thead">

                <tr>

                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>



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
                        {title: 'Name', name: 'name'},
                        {title: 'Email', name: 'email'},
                        {title: 'Create At', name: 'created_at'},


                    ],
                    filterGroups: [
                        {
                            filters: [
                                {title: 'Name', name: 'name', type: 'string'},
                                {title: 'Email', name: 'email', type: 'string'},
                                {title: 'Created At', name: 'created_at', type: 'datetime'},
                            ]

                        }
                    ]
                }
            }
        },




    }
</script>

