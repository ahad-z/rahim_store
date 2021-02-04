@extends('master')
@section('content')
<div class="row">
               <div class="col-md-1"></div>
               <div class="col-md-10">
                 <a class="btn btn-success btn-lg mb-4" style="float:right"  href="#modalAddProduct" data-toggle="modal">+ Add Product</a>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Expiry date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                               
                        </tbody>
                    </table>
               </div>
               <div class="col-md-1"></div>
           </div>  
           <!-- Modal for add product  -->
            <div class="modal fade" id="modalAddProduct">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form-group" method="POST" id="myForm">
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" class="form-control product_name" name="product_name" >
                                    <span class="invalid-feedback" id="product_name-feedback" role="alert"></span>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control price" name="price" >
                                    <span class="invalid-feedback" id="price-feedback" role="alert"></span>
                                </div>
                                <div class="form-group">
                                    <label for="expiry_datedate">Expiry date</label>
                                    <input type="date" class="form-control expiry_date" name="expiry_date" >
                                    <span class="invalid-feedback" id="expiry_date-feedback" role="alert"></span>
                                </div>
                                <button class="btn btn-info" id="submit">+ Add Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           <!-- End modal -->
            <!-- Modal for Edit product  -->
            <div class="modal fade" id="editProductModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Product</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form-group" method="POST" id="myForm">
                                <input type="hidden" name="product_id" value="" id ="product_id">
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" class="form-control edit_product_name" name="product_name" >
                                    <span class="invalid-feedback" id="product_name-feedback" role="alert"></span>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control edit_price" name="price" >
                                    <span class="invalid-feedback" id="price-feedback" role="alert"></span>
                                </div>
                                <div class="form-group">
                                    <label for="expiry_datedate">Expiry date</label>
                                    <input type="date" class="form-control edit_expiry_date" name="expiry_date" >
                                    <span class="invalid-feedback" id="expiry_date-feedback" role="alert"></span>
                                </div>
                                <button class="btn btn-success" id="update_btn_submit" value=""> Update Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           <!-- End modal -->
@endsection
@push('scripts')
<script>
    let allProducts = []
    let getUrl = '{{ route('getAllProduct') }}'

    function getAllProduct(){
        $.ajax({
            url: getUrl,
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
                             <td>
                                    <div class="btn-group">
                                        <a class="btn btn-info btn-sm"  onclick="edit('${data[i].id}')" href="#editProductModal" data-toggle="modal"><i class="fa fa-edit"></i></a>
                                    <button class="btn btn-danger btn-sm" onclick="removeProduct('${data[i].id}')"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        `
                tBody.append(row)
            }
        }
let ValidateErrorProduct_Name = false
function validateProductName(){
    let product_name = $(".product_name").val();
    if(product_name =='' ){
        $("#product_name-feedback").text("Please Enter Product Name")
        $("#product_name-feedback").css("display", "block")
        ValidateErrorProduct_Name = true
    }else{
        $("#product_name-feedback").text("")
        $("#product_name-feedback").css("display", "none")
        ValidateErrorProduct_Name = false
    }
}
let ValidateErrorPrice = false
function validatePrice(){
    let price = $(".price").val();
    if(price =='' ){
        $("#price-feedback").text("Please Enter Product Name")
        $("#price-feedback").css("display", "block")
        ValidateErrorPrice = true
    }else{
        $("#price-feedback").text("")
        $("#price-feedback").css("display", "none")
        ValidateErrorPrice = false
    }
}

let ValidateErrorExpiry = false
function validateExpiryDate(){
    let expiry_date = $(".expiry_date").val();
    if(expiry_date == '' ){
        $("#expiry_date-feedback").text("Please Enter Product Expiry Date")
        $("#expiry_date-feedback").css("display", "block")
        ValidateErrorExpiry = true
    }else{
        $("#expiry_date-feedback").text("")
        $("#expiry_date-feedback").css("display", "none")
        ValidateErrorExpiry = false
    }
}

$(".product_name").keyup(function(){
    validateProductName()
})
 $(".price").keyup(function(){
    validatePrice()
})
$(".expiry_date").keyup(function(){
    validateExpiryDate()
})
function resetForm(){
    $("#myForm").trigger("reset")
}

let token = document.querySelector(`meta[name='csrf-token']`).content;
let url = '{{ route("store") }}'
    $("#submit").click(function(e){
        e.preventDefault()
        let product_name = $(".product_name").val();
        let price        = $(".price").val();
        let expiry_date  = $(".expiry_date").val();
        validateProductName()
        validatePrice()
        validateExpiryDate()
        if(!ValidateErrorProduct_Name && !ValidateErrorPrice && !ValidateErrorExpiry ){
            $.ajax({
            url: url,
            type: "POST",
            data: {
                _token: token,
                product_name: product_name,
                price: price,
                expiry_date: expiry_date,
            },
            dataType:"JSON",
            success:(res) => {
                if(res.status){
                    $('#modalAddProduct').modal('hide')
                    toastr.success(res.message);
                    resetForm()
                    getAllProduct()
                }else{
                    toastr.error(res.message);
                }
            },
            error:(e) => {
                console.log(e)
                Object.keys(e.responseJSON.errors).forEach((key) => {
                    toastr.error(e.responseJSON.errors[key][0]);
                })
            }
        });
        }

    })

function edit(id){
    let product_id = id;
    let product_name = $('.edit_product_name');
    let price = $('.edit_price');
    let expiry_date = $('.edit_expiry_date');
    let edit_product_id = $('#product_id');
    let eidtUrl = '{{ url('products') }}/' + product_id;
       $.ajax({
            url: eidtUrl,
            type: "GET",
            dataType:"JSON",
            success:(res) => {
               product_name.val(res.product.product_name) 
               price.val(res.product.price) 
               expiry_date.val(res.product.expiry_date.slice(0, 10)) 
               edit_product_id.val(res.product.id)
               getAllProduct()
            },
            error:(e) => {
                console.log(e)
            }
        });
}

$('#update_btn_submit').on('click', function(e){
    e.preventDefault();
    let edit_product_name = $('.edit_product_name').val();
    let edit_price = $('.edit_price').val();
    let edit_expiry_date = $('.edit_expiry_date').val();
    let product_id = $('#product_id').val();
    let updateUrl = "{{ route('update') }}";

    $.ajax({
        
        url: updateUrl,
        type: "post",
        data: {
             _token: token,
            product_id :product_id,
             product_name: edit_product_name,
            price: edit_price,
            expiry_date: edit_expiry_date,
        },
        dataType:"JSON",
        success:(res) => {
            if(res.status){
                $('#editProductModal').modal('hide')
                toastr.success(res.message);
                resetForm()
                getAllProduct()
            }
        },
        error:(e) => {
            Object.keys(e.responseJSON.errors).forEach((key) => {
                toastr.error(e.responseJSON.errors[key][0]);
            })
        }
    });
})

function removeProduct(id){
    let deleteUrl  = '{{ URL("delete")}}/'+id;
   let confirm_btn = confirm("Are u sure to remove this task!");
   if(confirm_btn){
        $.ajax({
            url: deleteUrl,
            type: "DELETE",
            data: {
                _token: token,
            },
            dataType:"JSON",
            success:(res) => {
                if(res.status){
                    toastr.error(res.message);
                    getAllProduct()
                }
            },
            error:(e) => {
                console.log(e)
            }
        });
   }
}
</script>
@endpush