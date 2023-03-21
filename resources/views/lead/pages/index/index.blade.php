<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Qualify | Seniority</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
        body {
            background: #215b85;
        }
        .navbar-brand img {
            height: 50px;
            object-fit: contain
        }

        .form-group label.error {
            color: red;
            margin-top: 5px;
            font-weight: 400;
            font-size: 12px
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light shadow-sm p-3 mb-5 bg-white ">
        <div class="container">
            <div class="w-100 d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="{{ route("{$prefix}/index") }}">
                    <img src="https://static.wixstatic.com/media/b93998_3d731f2333c54ea294d3efdbed8a570b~mv2.png/v1/fill/w_301,h_116,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/seniority%20horizontal.png"
                        alt="">
                </a>
                {{-- <a href="{{route('ambassador/index')}}" class="btn btn-success">Become an Ambassador</a> --}}
            </div>
        </div>
    </nav>
    <div class="container mb-5">
        <div class="row align-items-center">
            <div class="col-md-5">
                <h2 class="text-light">Government Backed </h2>
                <h2 class="text-light">Lifetime Forbearance Mortgage* </h2>
                <div class="alert alert-info mt-3">
                    HECM (H0me Equity Conversion Mortgage) and You must pay annually property taxes, property insurance,
                    any HOA
                    and maintain property
                </div>
            </div>
            <div class="col-md-7">
                <div class="shadow p-5 bg-white rounded">
                    <h4 class="text-center mb-5">Let's see if you qualify?
                    </h4>
                    <form action="" id="formLead" data-url="{{ route("{$prefix}/save") }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="first_name" class="mb-2">
                                        First Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="first_name" id="first_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="middle_name" class="mb-2">
                                        Middle Name
                                       
                                    </label>
                                    <input type="text" class="form-control" name="middle_name" id="middle_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="last_name" class="mb-2">
                                        Last Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="last_name" id="last_name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="address" class="mb-2">
                                        Address
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="address" id="address">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="mobile" class="mb-2">
                                        Mobile
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" class="form-control" name="mobile" id="mobile">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="email" class="mb-2">
                                        Email
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="value_of_home" class="mb-2">
                                        Value of Home
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="value_of_home" id="value_of_home">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="mortgage_balance" class="mb-2">
                                        Mortgage balance 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="mortgage_balance" id="mortgage_balance">
                                </div>
                            </div>
                          
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="birthdate_of_youngest_person" class="mb-2">
                                        Birth date of youngest person in the home
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" name="birthdate_of_youngest_person" id="birthdate_of_youngest_person">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="marital_status" class="mb-2">
                                        Marital status
                                        <span class="text-danger">*</span>
                                    </label>
                                  <select name="marital_status" id="marital_status" class="form-control">
                                    <option value="married">Married</option>
                                    <option value="single">Single</option>
                                    <option value="widow">Widow</option>
                                  </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="ss_incom_annually" class="mb-2">
                                        SS income annually
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="ss_incom_annually" id="ss_incom_annually">
                                </div>
                            </div>
                           
                            <div class="col-md-12 text-center">
                                <button class="btn btn-primary btn-loading">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const getFormData = ($form) => {
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};
            jQuery.map(unindexed_array, function(n, i) {
                indexed_array[n["name"]] = n["value"];
            });
            return indexed_array;
        };
        const showLoading = () => {
            const btnLoading = $(".btn-loading");
            btnLoading.attr('disabled', true);
            btnLoading.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading');
        }
        const hideLoading = () => {
            const btnLoading = $(".btn-loading");
            btnLoading.attr('disabled', false);
            btnLoading.html('Submit');
        }
        jQuery(function($) {
            const formLead = $("#formLead");
            formLead.validate({
                rules: {
                    first_name: "required",
                    last_name: "required",
                    age: "required",
                    value_of_home: "required",
                    amount_owed: "required",
                    mobile: "required",
                    email: {
                        required: true,
                        email: true,
                    },
                },
                submitHandler: function(form) {
                    let url = formLead.data('url');
                    let data = getFormData(formLead);
                    $.ajax({
                        type: "post",
                        url: url,
                        data: data,
                        dataType: "json",
                        beforeSend: function(response) {
                            showLoading();
                        },
                        success: function(response) {
                            swal("Good job!", "Thanks for submitting!", "success").then(()=> {
                                location.reload();
                            });

                        },
                        complete: function() {
                            hideLoading();
                        }
                    });
                    console.log(data);
                    return false;
                }
            })
        });
    </script>
</body>

</html>
