@extends('sale.master')
@section('content')
    <div class="main-content">

        <div class="page-content">

            <div class="container-fluid">

  
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Orders</h4>
                        <a  href="{{route('sale.order.create')}}" class="btn btn-secondary waves-effect waves-light btn-submit  mb-3"  style="    color: #fff !important;">Create </a>

                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                <tr>
                                
                                    <th>Consumer</th>
                                    <th>Products</th>
                                    <th>Description</th>
                                    <th>Additional Amount</th>
                                    <th>Total Amount</th>
                                    <th>Is Paid Full</th>
                                    <th>Is Freeship</th>
                                    <th>Deposit Amount</th>
                                    <th>Viettel Order Amount</th>
                                    <th>Final Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td><a href="{{route('sale.order.detail', $order->id)}}">{!! implode('<br>', [
                                            $order->name,
                                            $order->phone,
                                            $order->address,
                                            ]) !!}</a>
                                        </td>
                                   
                                        <td>
                                            @foreach($order->products as $product)
                                            <div class="mt-1">
                                            <a href="{{route('sale.product.detail', $product->id)}}">{{$product->name}}<img src="{{asset($product->path_thumb)}}" alt="" height="100" class="ml-1"></a>
                                            
                                            </div>
                                            <br>
                                            @endforeach
                                
                                        </td>
                                        <td>{{$order->desc}}</td>
                                        <td>{{number_format($order->additional_amount)}}đ</td>
                                        <td><span >{{number_format($order->total_amount)}}đ</span></td>
                                        <td>{{$order->is_paid ? 'Yes' : 'No'}}</td>
                                        <td>{{$order->is_freeship ? 'Yes' : 'No'}}</td>
                                        <td><span >{{number_format($order->deposit_amount)}}đ</span></td>
                                        <td><span style="background-color:grey; color:white; padding: 5px">{{number_format($order->is_paid ? 0 : $order->total_amount - $order->deposit_amount)}}đ</span></td>
                                        <td>{{number_format($order->final_amount)}}đ</td>
                                       
                                        <td>
                                            @if($order->status == 'NEW')
                                            <span class="right badge badge-light">{{$order->status}}</span>
                                            @elseif($order->status == 'READY FOR SHIPPING')
                                            <span class="right badge badge-info">{{$order->status}}</span>
                                            @else
                                            <span class="right badge badge-success">{{$order->status}}</span>
                                            @endif
                                        </td>
                                        <td><a  href="{{route('sale.order.detail.delete', $order->id)}}" class="btn btn-secondary waves-effect waves-light btn-submit  "  style="    color: #fff !important;">Delete </a></td>
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
