@extends('sale.master')
@section('content')
    <div class="main-content">

        <div class="page-content">

            <div class="container-fluid">


               
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Products</h4>
                        <a  href="{{route('sale.product.create')}}" class="btn btn-secondary waves-effect waves-light btn-submit  mb-3"  style="    color: #fff !important;">Create </a>

                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                <tr>
                                
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Thumb</th>
                                    <th>Import Price</th>
                                    <th>Price</th>
                                    <th>Sizes</th>
                                    <th>Url FB</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{$product->type}}</td>
                                        <td>
                                            <a href="{{route('sale.product.detail', $product->id)}}">{{$product->name}}</a>
                                        </td>
                                        <td><img src="{{asset($product->path_thumb)}}" alt="" style="width:200px"></td>
                                        <td>{{number_format($product->import_price)}}đ</td>
                                        <td>{{number_format($product->price)}}đ</td>
                                        <td>{!! implode('<br>',$product->sizes->map(function($size) {
                                            return $size->name . ': ' . intval($size->value) ;
                                            })->toArray()) !!}</td>
                                        <td>{{$product->url_detail}}</td>
                                        <td>
                                            @if($product->status == 'AVAILABLE')
                                            <span class="right badge badge-info">{{$product->status}}</span>
                                            @else
                                            <span class="right badge badge-danger">{{$product->status}}</span>
                                            @endif
                                        </td>
                                        <td><a  href="{{route('sale.product.detail.delete', $product->id)}}" class="btn btn-secondary waves-effect waves-light btn-submit  "  style="    color: #fff !important;">Delete </a></td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- end card-body-->
                </div>

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->



    </div>


@endsection
