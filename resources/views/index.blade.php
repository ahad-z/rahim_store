@extends('master')
    @section('content')
        <div class="row mb-4">
            <div class="col-md-4"></div>
            <div class="col-md-8">
                <h5 class="alert alert-info text-center">Welcome to Rahim shop</h5>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-5">
                <h4 class="text-success">Price Filter</h4>
                <button class="btn btn-info btn-sm" id="low_to_high">Low to High</button>
                <button class="btn btn-info btn-sm" id="hig_to_low">High to Low</button>
            </div>
            <div class="col-md-8">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th >Product Name</th>
                            <th data-column="price" data-order="desc" class="tableData">Price</th>
                            <th data-column="Expire_date" data-order="desc" class="tableData">Expiry date</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                       
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
@push('scripts')
    <script>
        let allProducts = [];
        let url = '{{ route('allProduct') }}';
        function getAllProduct(){
            $.ajax({
                url: url,
                type: "GET",
                dataType:"JSON",
                success:(res) => {
                    allProducts = res.products
                    createTbody(allProducts)
                },
                error:(e) => {
                    console.log(e)
                }
            });
        }
        getAllProduct()
        function createTbody(data){

            let tBody = $('#myTable');
            tBody.empty()
            for(let i=0; i< data.length; i++){
                let row = `
                        <tr>
                            <td>${i+1}</td>
                            <td>${data[i].product_name}</td>
                            <td>${data[i].price}</td>
                            <td>${data[i].expiry_date.slice(0, 10)}</td>
                        </tr>
                        `
                tBody.append(row)
            }
        }
        $('#low_to_high').on('click', function(){

                let column = $('.tableData').attr('data-column')
                let order = $('.tableData').attr('data-order')
                if(order == 'desc'){
                  $('.tableData').attr("data-order","asc")
                  allProducts = allProducts.sort((a,b) => a[column] > b[column] ? 1 : -1)
                } 
                createTbody(allProducts)
        })

        $('#hig_to_low').on('click', function(){
           let column = $('.tableData').attr('data-column')
           let order = $('.tableData').attr('data-order')
            if(order == 'asc'){
                $('.tableData').attr("data-order","desc")
                allProducts = allProducts.sort((a,b) => a[column] < b[column] ? 1 : -1)
            } 
            createTbody(allProducts)
        })
    </script>
@endpush