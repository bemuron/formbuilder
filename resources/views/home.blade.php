@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
  <div>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-style1 mg-b-10">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Forms</li>
      </ol>
    </nav>
    <h4 class="mg-b-0 tx-spacing--1" id="page-title">Manage Forms</h4>
  </div>
  <div class="d-none d-md-block">
    <button class="btn btn-sm pd-x-15 btn-warning btn-uppercase" id="createFormBtn"><i data-feather="plus-circle" class="wd-10 mg-r-5"></i> Create Form</button>
  </div>
</div>

<div class="container mt-5">

  <table id="forms_table" class="table table-sm caption-top table-striped">
    <thead class="thead-dark">
      <tr>
        <th class="wd-10p">Form Name</th>
        <th class="wd-10p">Form Title</th>
        <th class="wd-5p">Description</th>
        <th class="wd-10p">Form Code</th>
        <th class="wd-5p">Created On</th>
        <th class="wd-5p">Created By</th>
        <th class="wd-10p">Action</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>

<!-- <hr class="mg-t-50 mg-b-40"> -->

<!-- modal to handle form creation -->
<div class="modal fade" id="form_modal" tabindex="-1" role="dialog" aria-labelledby="electionsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content tx-14">
          <div class="modal-header">
            <h6 class="modal-title" id="electionsModalLabel">Create Your Form</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </button>
          </div>

          <form id="addElectionForm"  enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row row-sm">
              <div class="col-sm-6">
                <input type="text" class="form-control" id="form-title" placeholder="Form Title">
              </div>
              <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                <textarea class="form-control" id="form-description" name="form-description" rows="2" cols="10" required placeholder="Brief description"></textarea>
              </div>
            </div><!-- row -->

          @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
          @endif
            
              @csrf
              <div class="form-group col">

                <div class="row">
                  <div class="col-4 border-right">

                    <button style="margin-bottom: 10px !important;" type="button" id="btnInputField" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Add a text input field">
                        <i data-feather="type"></i> Text Input Field
                    </button>

                    <button style="margin-bottom: 10px !important;" type="button" id="btnEmailInputField" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Add an email input field">
                        <i data-feather="at-sign"></i> Email Input Field
                    </button>

                    <button style="margin-bottom: 10px !important;" type="button" id="btnNumInputField" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Add a number input field">
                        <i data-feather="hash"></i> Number Input Field
                    </button>

                    <button style="margin-bottom: 10px !important;" type="button" id="btnDateInputField" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Add date input field">
                        <i data-feather="calendar"></i> Date Input
                    </button>

                    <button style="margin-bottom: 10px !important;" type="button" id="btnRadioInputField" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Add single choice button">
                        <i data-feather="circle"></i> Radio Buttons
                    </button>

                    <button style="margin-bottom: 10px !important;" type="button" id="btnCheckInputField" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Add check boxes">
                        <i data-feather="check-square"></i> Check Boxes
                    </button>

                    <button style="margin-bottom: 10px !important;" type="button" id="btnTxAreaInputField" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Add a text area">
                        <i data-feather="file-text"></i> Text Area
                    </button>

                  </div>

                  <!-- <div> -->
                    <div id="componentContainer" class="col-8" >
                      <div class="componentItem"  data-item="0">
                      </div>
                    </div>
                  <!-- </div> -->

                </div><!-- row -->
              </div>

              <!-- text input -->
              <div id="tIField" class="form-group d-none parentTIDiv">
                <div class="componentItem"  data-item="0">
                  <div class="row">
                    <div class="col-1">
                      <a href="#" class="removeItem tx-danger"><i data-feather="trash-2" style="margin-top: 5px;"></i></a>
                      <span class="item-move"><i class="fa fa-arrows"></i></span>
                    </div>

                    <div class="col-11">
                      <label for="txInput"contenteditable="true"  class="mg-b-0 col-form-label tx-spacing-1 fw-bold text-md-right"> Your Question here <i class='bi bi-pencil'></i></label>
                      <input type="text" class="form-control" id="textInput" name="txInput[]">
                      <div class="form-check">
                          <input class="form-check-input req-item" type="checkbox" value="" >
                          <label class="form-check-label req-chk" for="">
                              * Is Required?
                          </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- email input -->
              <div id="emailField" class="form-group d-none parentEmailDiv">
                <div class="componentItem"  data-item="0">
                  <div class="row">
                    <div class="col-1">
                      <a href="#" class="removeItem tx-danger"><i data-feather="trash-2" style="margin-top: 5px;"></i></a>
                      <span class="item-move"><i class="fa fa-arrows"></i></span>
                    </div>

                    <div class="col-11">
                      <label for="emailInput"contenteditable="true"  class="mg-b-0 col-form-label tx-spacing-1 fw-bold text-md-right"> Your Question here <i class='bi bi-pencil'></i></label>
                      <input type="email" class="form-control" id="emailInputId" placeholder="Email address" name="emailInput[]">
                      <div class="form-check">
                          <input class="form-check-input req-item" type="checkbox" value="" >
                          <label class="form-check-label req-chk" for="">
                              * Is Required?
                          </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- number input -->
              <div id="numberField" class="form-group d-none parentNumberDiv">
                <div class="componentItem"  data-item="0">
                  <div class="row">
                    <div class="col-1">
                      <a href="#" class="removeItem tx-danger"><i data-feather="trash-2" style="margin-top: 5px;"></i></a>
                      <span class="item-move"><i class="fa fa-arrows"></i></span>
                    </div>

                    <div class="col-11">
                      <label for="numberInput"contenteditable="true"  class="mg-b-0 col-form-label tx-spacing-1 fw-bold text-md-right"> Your Question here <i class='bi bi-pencil'></i></label>
                      <input type="number" class="form-control" id="numInputId" name="numberInput[]">
                      <div class="form-check">
                          <input class="form-check-input req-item" type="checkbox" value="" >
                          <label class="form-check-label req-chk" for="">
                              * Is Required?
                          </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- date input -->
              <div id="dateField" class="form-group d-none parentDateDiv">
                <div class="componentItem"  data-item="0">
                  <div class="row">
                    <div class="col-1">
                      <a href="#" class="removeItem tx-danger"><i data-feather="trash-2" style="margin-top: 5px;"></i></a>
                      <span class="item-move"><i class="fa fa-arrows"></i></span>
                    </div>

                    <div class="col-11">
                      <label for="dateInput"contenteditable="true"  class="mg-b-0 col-form-label tx-spacing-1 fw-bold text-md-right"> Your Question here <i class='bi bi-pencil'></i></label>
                      <input type="text" class="form-control" id="dateInputId" name="dateInput[]">
                      <div class="form-check">
                          <input class="form-check-input req-item" type="checkbox" value="" >
                          <label class="form-check-label req-chk" for="">
                              * Is Required?
                          </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- radio buttons -->
              <div id="radioButtons" class="form-group d-none">
                <div class="componentItem"  data-item="0">
                  <div class="row">
                    <div class="col-1">
                      <a href="#" class="removeItem tx-danger"><i data-feather="trash-2" style="margin-top: 5px;"></i></a>
                      <span class="item-move"><i class="fa fa-arrows"></i></span>
                    </div>

                    <div class="col-11">
                      <label for="customRadio"contenteditable="true"  class="mg-b-0 col-form-label tx-spacing-1 fw-bold text-md-right"> Your Question here <i class='bi bi-pencil'></i></label>

                      <button type="button" class="add_radio btn btn-sm btn-outline-dark"><i class="fa fa-plus"></i> Add option</button>

                      <div class="form-check mg-t-5">
                          <input class="form-check-input req-item" type="checkbox" value="" >
                          <label class="form-check-label req-chk" for="">
                              * Is Required?
                          </label>
                      </div>
                    </div>

                  </div><!-- row -->
                </div>
              </div>

              <!-- check boxes -->
              <div id="checkBoxes" class="form-group d-none">
                <div class="componentItem"  data-item="0">
                  <div class="row">
                    <div class="col-1">
                      <a href="#" class="removeItem tx-danger"><i data-feather="trash-2" style="margin-top: 5px;"></i></a>
                      <span class="item-move"><i class="fa fa-arrows"></i></span>
                    </div>

                    <div class="col-11">
                      <label for="checkBox" contenteditable="true"  class="mg-b-0 col-form-label tx-spacing-1 fw-bold text-md-right"> Your Question here <i class='bi bi-pencil'></i></label>

                      <button type="button" class="add_chk btn btn-sm btn-outline-dark"><i class="fa fa-plus"></i> Add option</button>

                      <div class="form-check mg-t-5">
                          <input class="form-check-input req-item" type="checkbox" value="" >
                          <label class="form-check-label req-chk" for="">
                              * Is Required?
                          </label>
                      </div>
                    </div>

                  </div><!-- row -->
                </div>
              </div>

              <!-- text area -->
              <div id="textAreaCon" class="form-group d-none">
                <div class="componentItem"  data-item="0">
                  <div class="row">
                    <div class="col-1">
                      <a href="#" class="removeItem tx-danger"><i data-feather="trash-2" style="margin-top: 5px;"></i></a>
                      <span class="item-move"><i class="fa fa-arrows"></i></span>
                    </div>

                    <div class="col-11">
                      <label for="txtAreaInput"contenteditable="true"  class="mg-b-0 col-form-label tx-spacing-1 fw-bold text-md-right"> Your Question here <i class='bi bi-pencil'></i></label>
                      <textarea class="form-control" id="txtAreaId" name="txtAreaInput[]" rows="5" cols="10" required placeholder="Brief description"></textarea>
                      <div class="form-check">
                          <input class="form-check-input req-item" type="checkbox" value="" >
                          <label class="form-check-label req-chk" for="">
                              * Is Required?
                          </label>
                      </div>
                    </div>

                  </div><!-- row -->
                </div>
              </div>

              <!-- file upload -->
              <div class="form-group d-none pt-5">
                <div class="componentItem"  data-item="0">

                  <div class="row">
                    <div class="col-1">
                      <a href="#" class="removeItem tx-danger"><i data-feather="trash-2" style="margin-top: 5px;"></i></a>
                      <span class="item-move"><i class="fa fa-braille"></i></span>
                    </div>

                    <div class="col-11">
                      <label for="fileUpload" class="mg-b-0 col-form-label tx-spacing-1 fw-bold text-md-right"> <span class="text-danger">*</span></label>
                      <input id="fUpload" type="file" class="form-control" name="fileUpload[]">
                    </div>

                  </div><!-- row -->
                </div>
              </div>
            
            
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-bs-dismiss="modal">Close</button>
          <button type="button" id="saveFormBtn" class="btn btn-success"><i data-feather="save" class="mg-r-5"></i> Create Form</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <!-- modal to confirm with user if they want to delete the form -->
  <div class="modal fade" id="delete_form_modal" tabindex="-1" role="dialog" aria-labelledby="confirmFormDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content tx-14">
        <div class="modal-header">
          <h6 class="modal-title" id="confirmFormDelete">Confirm Delete</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </button>
        </div>
        <div class="modal-body">
          <p id="deleteFormText"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary tx-13" data-bs-dismiss="modal">Close</button>
          <button type="button" id="deletFormBtn"class="btn btn-danger"> <i data-feather="trash" class="wd-10 mg-r-5"></i>Delete</button>
        </div>
      </div>
    </div>
  </div>
@endsection
