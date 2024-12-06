@extends('layouts.main')

@section('content')
<div class="content-wrapper">
   <div class="pagetitle">
        <h1>Purchase Order <span class="text-danger">Change</span></h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Orders</a></li>
          <li class="breadcrumb-item active">Purchase Order Change</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

      <div class="row">
        <div class="alert alert-warning" role="alert">
          <i class="fa-solid fa-triangle-exclamation"></i>
          *** The Purchase Order consider accepted if there is no reply within 5 days ***
        </div>
      </div>
      <div class="row">
      </div>
      <div class="row">
        <div class="card recent-sales overflow-auto ml-3">
          <div class="card-body">
            <h5 class="card-title">FILTER</h5>
            <form class="row g-3 ml-3" name="submit_poc" method="get">
              <div class="col-md-6">
                <div class="col-md-12">
                  <label for="supplier" class="form-label">Supplier</label>
                  <select type="text" id="supplier" name="supplier" class="form-control"></select>
                </div>
                <div class="row mt-2">
                  <div class="col-md-6">
                    <label for="from_date" class="form-label">From</label>
                    <input type="date" name="from_date" class="form-control" id="from_date" value="<?= date('Y-m-d') ?>">
                  </div>
                  <div class="col-md-6">
                    <label for="end_date" class="form-label">To</label>
                    <input type="date" name="end_date" class="form-control" id="end_date" value="<?= date('Y-m-d') ?>">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="col-12">
                  <label for="filter_by" class="form-label">Filter By</label>
                  <select class="form-select" name="filter_by" id="filter_by" data-placeholder="Filter By">
                    <option>--Select Category--</option>
                  </select>
                </div>
                <div class="col-12 mt-2">
                  <label for="select_poc" class="form-label mb-2">Select Based on Filter by</label>
                  <br>
                  <select class="form-select col-12" name="select_poc" id="select_poc" data-placeholder="Search Item" multiple>
                  </select>
                </div>
              </div>
              <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
                <button type="reset" class="btn btn-secondary ">Reset</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="message"></div>
      </div>
      <div class="loading row col-12 mb-2 d-flex justify-content-center">
        <div class="spinner-border text-info mt-2" role="status">
          {{-- <span class="visually-hidden">Loading...</span> --}}
        </div>
      </div>

      <div class="row">
        <div class="card recent-sales overflow-auto ml-3">
          <div class="card-header">
            DATA PURCHASE ORDER CHANGE
          </div>
          <div class="card-body">
            <table id="table-purchase-order-change" class="table table-striped ml-3 display responsive nowrap">
            </table>
          </div>
        </div>
      </div>


</div><!-- End #main -->
  @endsection
  @section('script')
  <script src="./dist/jpoc.bundle.js"></script>
  @endsection