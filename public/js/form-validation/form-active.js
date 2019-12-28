(function ($) {
    "use strict";
    // Validation for order form
    $(".add-professors").validate(
        {

            rules:
                {
                    'frm[firstName]':
                        {
                            required: true,
                            minlength: 3,

                        },
                    'frm[lastName]':
                        {
                            required: true,
                            minlength: 3,

                        },
                    'frm[name]':
                        {
                            required: true,
                            minlength: 3,

                        },
                    'frm[id]':
                        {
                            required: true,

                        },
                    'frm[classId]':
                        {
                            required: true,

                        },
                    'frm[capacity]':
                        {
                            required: true,
                            number: true,
                            min: 0,
                            max: 30

                        },
                    parentName1:
                        {
                            required: true,
                            minlength: 3,

                        },
                    parentName2:
                        {
                            required: true,
                            minlength: 3,

                        },
                    'frm[email]':
                        {
                            required: true,
                            email: true

                        },
                    parentEmail1:
                        {
                            required: true,
                            email: true

                        },
                    parentEmail2:
                        {
                            required: true,
                            email: true

                        },

                    email:
                        {
                            required: true,
                            email: true
                        },
                    'frmT[subject]':
                        {
                            required: true
                        },
                    'frm[skill]':
                        {
                            required: true,
                            min: 0,
                            max: 10
                        },
                    'frm[postCode]':
                        {
                            minlength: 5,
                            maxlength: 5,
                            number: true
                        },
                    'frm[fiscalCode]':
                        {
                            fiscalCode: true
                        },
                    'frm[phone]':
                        {
                            number: true,
                            minlength: 10,
                            maxlength: 10
                        },
                    'frmT[idClass]':
                        {
                            required: true
                        },
                    'frm[gender]':
                        {
                            required: true
                        },
                    'frm[birthPlace]':
                        {
                            lettersonly: true,
                        },
                    password: {
                        minlength: 8
                    },
                    confirmPassword: {
                        minlength: 8,
                        equalTo: "#password"
                    },
                    'frm[password]': {
                        required:true,
                        minlength: 8
                    },
                    confirm_password: {
                        minlength: 8,
                        equalTo: "#password"
                    }
                },
            messages:
                {
                    'frm[firstName]':
                        {
                            required: 'Please enter first name'
                        },
                    'frm[lastName]':
                        {
                            required: 'Please enter last name'
                        },
                    'frm[name]':
                        {
                            required: 'Please enter name'
                        },
                    'frm[id]':
                        {
                            required: 'Please enter class name'
                        },
                    'frm[classId]':
                        {
                            required: 'Please select a classroom'
                        },
                    'frm[capacity]':
                        {
                            required: 'Please enter capacity'
                        },
                    parentName1:
                        {
                            required: 'Please enter parent1 name'
                        },
                    parentName2:
                        {
                            required: 'Please enter parent2 name'
                        },
                    'frm[email]':
                        {
                            required: 'Please enter email'
                        },
                    email:
                        {
                            required: 'Please enter email'
                        },
                    parentEmail1:
                        {
                            required: 'Please enter email'
                        },
                    parentEmail2:
                        {
                            required: 'Please enter email'
                        },
                    'frmT[subject]':
                        {
                            required: 'Please enter subject'
                        },
                    'frm[postCode]':
                        {
                            required: 'Please enter postcode'
                        },
                    'frm[skill]':
                        {
                            required: 'Please enter skill'
                        },
                    'frm[fiscalCode]':
                        {
                            fiscalCode: 'Please enter a valid fiscal code',
                        },
                    'frm[phone]':
                        {
                            required: 'Please enter phone'
                        },
                    'frmT[idClass]':
                        {
                            required: 'Please select Class'
                        },
                    'frm[gender]':
                        {
                            required: 'Please select gender'
                        },
                    'frm[birthPlace]':
                        {
                            required: 'Please enter place of birth'
                        },
                },

            submitHandler: function (form, event, error) {
                if (error) {

                    event.preventDefault();
                    //submit via ajax
                    return false;  //This doesn't prevent the form from submitting
                } else {

                    form.submit();
                }
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            },


        });


    $.validator.addMethod('fiscalCode', function (value, element, param) {
        var regex = /^[A-Za-z]{6}[0-9]{2}[A-Za-z]{1}[0-9]{2}[A-Za-z]{1}[0-9]{3}[A-Za-z]{1}$/;
        return value.match(regex);
    }, 'Please enter a valid fiscal code!');

    jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
    }, "Letters only please");

    $(".add-parents").validate(
        {

            rules:
                {
                    parentName1:
                        {
                            lettersonly: true,
                            minlength: 3,

                        },
                    parentName2:
                        {
                            lettersonly: true,
                            minlength: 3,

                        },
                    parentEmail1:
                        {
                            email: true

                        },
                    parentEmail2:
                        {
                            email: true

                        }
                },
            messages:
                {
                    parentName1:
                        {
                            required: 'Please enter name'
                        },
                    parentName2:
                        {
                            required: 'Please enter name'
                        },
                    parentEmail1:
                        {
                            required: 'Please enter email'
                        },
                    parentEmail2:
                        {
                            required: 'Please enter email'
                        }
                },

            submitHandler: function (form, event, error) {
                if (error) {

                    event.preventDefault();
                    //submit via ajax
                    return false;  //This doesn't prevent the form from submitting
                } else {

                    form.submit();
                }
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            },


        });


    // Validation for order form
    $("#acount-infor").validate(
        {
            rules:
                {
                    email:
                        {
                            required: true,
                            email: true
                        },
                    phoneno:
                        {
                            required: true
                        },
                    password:
                        {
                            required: true,
                            minlength: 3,
                            maxlength: 20
                        },
                    confarmpassword:
                        {
                            required: true,
                            minlength: 3,
                            maxlength: 20
                        }
                },
            messages:
                {

                    email:
                        {
                            required: 'Please enter your email address',
                            email: 'Please enter a VALID email address'
                        },
                    phoneno:
                        {
                            required: 'Please enter mobile number'
                        },
                    password:
                        {
                            required: 'Please enter your password'
                        },
                    confarmpassword:
                        {
                            required: 'Please enter your confarm password'
                        }

                },

            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });

    // Validation for order form
    $(".addcourse").validate(
        {
            rules:
                {
                    coursename:
                        {
                            required: true
                        },
                    finish:
                        {
                            required: true
                        },
                    duration:
                        {
                            required: true
                        },
                    price:
                        {
                            required: true
                        },
                    imageico:
                        {
                            required: true
                        },
                    department:
                        {
                            required: true
                        },
                    description:
                        {
                            required: true
                        },
                    crprofessor:
                        {
                            required: true
                        },
                    year:
                        {
                            required: true
                        },
                    email:
                        {
                            required: true,
                            email: true
                        },
                    phoneno:
                        {
                            required: true
                        },
                    password:
                        {
                            required: true,
                            minlength: 3,
                            maxlength: 20
                        },
                    confarmpassword:
                        {
                            required: true,
                            minlength: 3,
                            maxlength: 20
                        }
                },
            messages:
                {
                    coursename:
                        {
                            required: 'Please enter course name'
                        },
                    finish:
                        {
                            required: 'Please select date of birth'
                        },
                    duration:
                        {
                            required: 'Please enter duration'
                        },
                    price:
                        {
                            required: 'Please enter price'
                        },
                    imageico:
                        {
                            required: 'Please enter image'
                        },
                    department:
                        {
                            required: 'Please enter department'
                        },
                    description:
                        {
                            required: 'Please enter description'
                        },
                    crprofessor:
                        {
                            required: 'Please enter course professor'
                        },
                    year:
                        {
                            required: 'Please enter year'
                        },
                    email:
                        {
                            required: 'Please enter your email address',
                            email: 'Please enter a VALID email address'
                        },
                    phoneno:
                        {
                            required: 'Please enter mobile number'
                        },
                    password:
                        {
                            required: 'Please enter your password'
                        },
                    confarmpassword:
                        {
                            required: 'Please enter your confarm password'
                        }

                },

            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });


    // Validation for login form
    $("#comment").validate(
        {
            rules:
                {
                    name:
                        {
                            required: true
                        },
                    message:
                        {
                            required: true
                        },
                    email:
                        {
                            required: true,
                            email: true
                        }
                },
            messages:
                {
                    name:
                        {
                            required: 'Please enter your name'
                        },
                    message:
                        {
                            required: 'Please enter your message'
                        },
                    email:
                        {
                            required: 'Please enter your email address',
                            email: 'Please enter a VALID email address'
                        }
                },

            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });


    // Validation for login form
    $(".addlibrary").validate(
        {
            rules:
                {
                    nameasset:
                        {
                            required: true
                        },
                    subject:
                        {
                            required: true
                        },
                    imageico:
                        {
                            required: true
                        },
                    type:
                        {
                            required: true
                        },
                    price:
                        {
                            required: true
                        },
                    year:
                        {
                            required: true
                        },
                    status:
                        {
                            required: true
                        },
                    department:
                        {
                            required: true
                        },
                    email:
                        {
                            required: true,
                            email: true
                        }
                },
            messages:
                {
                    nameasset:
                        {
                            required: 'Please enter your name of assets'
                        },
                    subject:
                        {
                            required: 'Please enter your subject'
                        },
                    imageico:
                        {
                            required: 'Please enter image'
                        },
                    department:
                        {
                            required: 'Please enter your department'
                        },
                    type:
                        {
                            required: 'Please enter library type'
                        },
                    price:
                        {
                            required: 'Please enter price'
                        },
                    year:
                        {
                            required: 'Please enter year'
                        },
                    status:
                        {
                            required: 'Please enter status'
                        },
                    email:
                        {
                            required: 'Please enter your email address',
                            email: 'Please enter a VALID email address'
                        }
                },

            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });

    // Validation for login form
    $(".add-department").validate(
        {
            rules:
                {
                    name:
                        {
                            required: true
                        },
                    headofdepartment:
                        {
                            required: true
                        },
                    email:
                        {
                            required: true
                        },
                    phone:
                        {
                            required: true
                        },
                    noofstudent:
                        {
                            required: true
                        },
                    status:
                        {
                            required: true
                        }
                },
            messages:
                {
                    name:
                        {
                            required: 'Please enter your name'
                        },
                    headofdepartment:
                        {
                            required: 'Please enter head of department'
                        },
                    email:
                        {
                            required: 'Please enter email'
                        },
                    phone:
                        {
                            required: 'Please enter your phone'
                        },
                    noofstudent:
                        {
                            required: 'Please enter no of student'
                        },
                    status:
                        {
                            required: 'Please enter status'
                        }
                },

            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });

    // Validation for login form
    $("#send-mail").validate(
        {
            rules:
                {
                    name:
                        {
                            required: true
                        },
                    headofdepartment:
                        {
                            required: true
                        },
                    email:
                        {
                            required: true,
                            email: true
                        },
                    phone:
                        {
                            required: true
                        },
                    noofstudent:
                        {
                            required: true
                        },
                    status:
                        {
                            required: true
                        }
                },
            messages:
                {
                    name:
                        {
                            required: 'Please enter your name'
                        },
                    headofdepartment:
                        {
                            required: 'Please enter head of department'
                        },
                    email:
                        {
                            required: 'Please enter your email address',
                            email: 'Please enter a VALID email address'
                        },
                    noofstudent:
                        {
                            required: 'Please enter no of student'
                        },
                    status:
                        {
                            required: 'Please enter status'
                        }
                },

            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });


})(jQuery);
