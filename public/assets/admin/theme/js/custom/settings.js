$(document).ready(function () {
    $('form[id="general_setting_form"]').validate({
        rules: {
            "logo": {
                extension: "jpg|jpeg|png|gif"
            },
            "favicon": {
                extension: "ico|png"
            },
            "settings[company_name]": {
                required: true
            },
            "settings[address]": {
                required: true
            },
            "settings[city]": {
                required: true
            },
            "settings[state]": {
                required: true
            },
            "settings[country]": {
                required: true
            },
            "settings[zip_code]": {
                required: true,
                digits: true,
                minlength: 4,
                maxlength: 6
            },
            "settings[phone_number]": {
                required: true,
                pattern: /^[0-9,\s]+$/
            },
            "settings[email]": {
                required: true,
                email: true
            }
        },
        messages: {
            "logo": {
                extension: "Please upload a valid image file (jpg, jpeg, png, gif)."
            },
            "favicon": {
                extension: "Only ICO or PNG files are allowed."
            },
            "settings[company_name]": {
                required: "Please enter the company name."
            },
            "settings[address]": {
                required: "Please enter the address."
            },
            "settings[city]": {
                required: "Please enter the city."
            },
            "settings[state]": {
                required: "Please enter the state."
            },
            "settings[country]": {
                required: "Please enter the country."
            },
            "settings[zip_code]": {
                required: "Please enter a ZIP code.",
                digits: "Only numbers are allowed.",
                minlength: "ZIP code must be at least 4 digits.",
                maxlength: "ZIP code cannot exceed 6 digits."
            },
            "settings[phone_number]": {
                required: "Please enter a phone number.",
                pattern: "Only numbers and commas are allowed."
            },
            "settings[email]": {
                required: "Please enter an email address.",
                email: "Please enter a valid email address."
            }
        },
        submitHandler: function (form) {
            var formData = new FormData(form);
            $.ajax({
                url: BASE_URL + '/admin/settings/save',
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                cache: false,
                success: function (response) {
                    if (response?.status == true) {
                        location.reload();
                    }
                }
            });
        }
    });

    $('form[id="socialMedia_setting_form"]').validate({
        rules: {
            "settings[facebook]": {
                required: true,
                url: true
            },
            "settings[google_plus]": {
                required: true,
                url: true
            },
            "settings[youtube]": {
                required: true,
                url: true
            },
            "settings[instagram]": {
                required: true,
                url: true
            }
        },
        messages: {
            "settings[facebook]": {
                required: "Please enter a Facebook URL.",
                url: "Please enter a valid URL."
            },
            "settings[google_plus]": {
                required: "Please enter a Google Plus URL.",
                url: "Please enter a valid URL."
            },
            "settings[youtube]": {
                required: "Please enter a YouTube URL.",
                url: "Please enter a valid URL."
            },
            "settings[instagram]": {
                required: "Please enter an Instagram URL.",
                url: "Please enter a valid URL."
            }
        },
        submitHandler: function (form) {
            var formData = new FormData(form);
            $.ajax({
                url: BASE_URL + '/admin/settings/save',
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
                cache: false,
                success: function (response) {
                    if (response?.status == true) {
                        location.reload();
                    }
                }
            });
        }
    });

})
