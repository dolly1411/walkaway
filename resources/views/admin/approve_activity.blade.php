@extends('layouts.admin')

@section('content')
<div class="container-fluid">
<div class="content-wrapper">
	  <div class="row row-offcanvas row-offcanvas-right">
 <div class="card-deck">
            <div class="card col-lg-12 px-0 mb-4">
              <div class="card-body">
                <h5 class="card-title">Last Billings</h5>
                <div class="table-responsive">
                  <table class="table center-aligned-table">
                    <thead>
                      <tr class="text-primary">
                        <th>Order No</th>
                        <th>Product Name</th>
                        <th>Purchased On</th>
                        <th>Shipping Status</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="">
                        <td>034</td>
                        <td>Iphone 7</td>
                        <td>12 May 2017</td>
                        <td>Dispatched</td>
                        <td>Credit card</td>
                        <td><label class="badge badge-success">Approved</label></td>
                        <td><a href="#" class="btn btn-outline-success btn-sm">View Order</a></td>
                        <td><a href="#" class="btn btn-outline-warning btn-sm">Cancel</a></td>
                      </tr>
                      <tr class="">
                        <td>035</td>
                        <td>Galaxy S8</td>
                        <td>15 May 2017</td>
                        <td>Dispatched</td>
                        <td>Internet banking</td>
                        <td><label class="badge badge-warning">Pending</label></td>
                        <td><a href="#" class="btn btn-outline-success btn-sm">View Order</a></td>
                        <td><a href="#" class="btn btn-outline-warning btn-sm">Cancel</a></td>
                      </tr>
                      <tr class="">
                        <td>036</td>
                        <td>Amazon Echo</td>
                        <td>17 May 2017</td>
                        <td>Dispatched</td>
                        <td>Credit card</td>
                        <td><label class="badge badge-success">Approved</label></td>
                        <td><a href="#" class="btn btn-outline-success btn-sm">View Order</a></td>
                        <td><a href="#" class="btn btn-outline-warning btn-sm">Cancel</a></td>
                      </tr>
                      <tr class="">
                        <td>037</td>
                        <td>Google Pixel</td>
                        <td>17 May 2017</td>
                        <td>Dispatched</td>
                        <td>Cash on delivery</td>
                        <td><label class="badge badge-danger">Rejected</label></td>
                        <td><a href="#" class="btn btn-outline-success btn-sm">View Order</a></td>
                        <td><a href="#" class="btn btn-outline-warning btn-sm">Cancel</a></td>
                      </tr>
                      <tr class="">
                        <td>038</td>
                        <td>Mac Mini</td>
                        <td>19 May 2017</td>
                        <td>Dispatched</td>
                        <td>Debit card</td>
                        <td><label class="badge badge-success">Approved</label></td>
                        <td><a href="#" class="btn btn-outline-success btn-sm">View Order</a></td>
                        <td><a href="#" class="btn btn-outline-warning btn-sm">Cancel</a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
       </div>
      </div>
     </div>   
@endsection         
