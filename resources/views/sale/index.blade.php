@extends('sale.master')
@section('content')
    <div class="main-content">

        <div class="page-content">

            <div class="container-fluid">

            <div class="card">
                    <div class="card-body">
                    <h4 class="card-title">Summary</h4>
                    <div class="row">
                    <div class="col">
                        
                        Total Order New: {{$totalOrderNew}} <br>
                        Total Order New Price: {{number_format($totalOrderNewPrice)}}đ <br>
                        </div>
                        <div class="col">
                            
                            Total Product: {{$totalProduct}} <br>
                            Total Product Sold: {{$totalProductSold}} - {{$typeProductSold}} <br>
                            Total Product Available: {{$totalProductAvailable}} - {{$typeProductAvailable}} <br>
                        </div>
                        <div class="col">
                        Total All Import Price: {{number_format($totalAllImportPrice)}}đ <br>
                        Total Import Price: {{number_format($totalImportPrice)}}đ <br>
                        Total Order: {{$totalOrder}} <br>
                        Total Order Price: {{number_format($totalPrice)}}đ <br>
                        Total Order Final Price: {{number_format($totalFinalPrice)}}đ <br>
                        </div>
                    </div>
</div>
</div>
             

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->



    </div>


@endsection
