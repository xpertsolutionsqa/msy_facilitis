$(document).ready(function () {
    const lang = $('meta[name="lang"]').attr('content');
    $('.select2').select2();

    $('#FacilityFilter').on('change', function () {
        var v = document.getElementsByClassName(
            'item-content animate__animated animate__fadeIn active')[0].id;
        var selectedValue = ($(this).val());
        if (selectedValue != '') {
            window.location.href = window.location.href.split('?')[0] + "?fa=" + selectedValue +
                "&v=" + v;

        } else {
            window.location.href = window.location.href.split('?')[0] + "?v=" + v;
        }

    });

    $('input[type="file"]').on('change', function () {
        var maxSizeMb = $(this).attr('max');
        if (!maxSizeMb) {
            return;
        }
        var file = this.files[0];
        if (file) {
            var maxSizeBytes = maxSizeMb * 1048576;
            if (file.size > maxSizeBytes) {
                alert("Please select a smaller size file (Max " + maxSizeMb + " MB).");
                $(this).closest('form').find('button[type="submit"]').hide();
            } else {
                $(this).closest('form').find('button[type="submit"]').show();
            }
        }
    });


    const swiper = new Swiper('.Mainswiper', {
        loop: true,
        pagination: {
            el: '.swiper-pagination',
        },
    });

    const facilityswiper = new Swiper('.facilityswiper', {
        items: 2,
        effect: 'fade',
        autoplay: true,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
        },
    });

    var subswiper = new Swiper(".mySubSwiper", {
        slidesPerView: 2,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
        },

    });

    $('.clickableCard').click(function () {
        var link = $(this).data('url');
        window.location.href = link;
    });


    $('body').on('submit', 'form', function (e) {
        e.preventDefault();
        var loading="جاري الإرسال ...";
        if (lang != 'ar') {
            loading="sending...";
        }
        let isValid = true;
        const form = this;
        const submitButton = $(form).find('button[type="submit"]');
        console.log(submitButton);
        $(form).find('.required').each(function () {
            if ($(this).val().trim() == '') {
                isValid = false;
                $(this).css('border', '1px solid red').focus();
            } else {
                $(this).css('border', '');
            }
        });
        if (isValid) {
            submitButton.html('<span>'+loading+'</span><img style="height: 30px;" src="https://msy.gov.qa/sfb/public/assets/images/spinner.gif" alt="Loading...">');
            submitButton.prop('disabled', true);
            setTimeout(() => {
                form.submit();
            }, 50);
        }
    });

    $(document).ready(function () {
        $('#popoverButton').popover({
            trigger: 'click',
            html: true,
            content: function () {
                return $('#popoverContent').html();
            },
            placement: 'bottom'
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('#popoverButton').length) {
                $('#popoverButton').popover('hide');
            }
        });
    });


    $("#updatePasswordForm").submit(function (e) {
        e.preventDefault();
        var currentForm = $(this);
        var error = false;
        var newpass = document.getElementById('new_password').value;
        var confirm_password = document.getElementById('confirm_password').value;
        if (newpass.length < 8) {
            error = true;
            var errorMsg = 'عذرا كلمة المرور يجب أن لا تقل عن 8 حروف ';
            document.getElementById('pass-error-msg').textContent = errorMsg;
            return;
        } else {
            document.getElementById('pass-error-msg').textContent = '';
        }

        if (newpass != confirm_password) {
            error = true;
            var errorMsg = 'عذرا كلمة المرور غير متطابقة';
            document.getElementById('pass-error-msg').textContent = errorMsg;
            return;
        } else {
            document.getElementById('pass-error-msg').textContent = '';
        }

        if (error) {
            confirm_password.focus();
        }
        else {
            this.submit();
        }
    });




    $('body').on('change', '#acceptTerms', function () {
        $("#createBo").toggle(this.checked);
    });

    $('body').on('click', '.filebtn', function () {
        var link = $(this).attr('filepath');
        var extension = $(this).attr('extension');
        if (extension == 'png' || extension == 'jpeg' || extension == 'jpg') {
            $("#imagesrc").attr('src', 'https://www.msy.gov.qa/sfb/public/' + link);
            $('#image_view').modal('show');
        } else {
            window.open('https://www.msy.gov.qa/sfb/public/' + link, '_blank');
        }
    });

    $('#subTable').on('click', '.removeSub', function () {
        var count = parseInt($("#count").val());
        var id = $(this).attr('id');
        $("#subTableTr" + id).remove();
        $("#count").val(count - 1);

    });

    $('.subFa').change(function () {
        var subs = [];
        $('.subFa').each(function (index, obj) {
            if (this.checked === true) {
                subs.push($(this).attr('id'));
            }
        });
        $("#subs").val(subs.join(','));

    });

    $('#SearchGrid').on('keyup', function () {
        var value = $(this).val().toUpperCase();
        var cards = document.querySelectorAll('.facilityCard');
        cards.forEach(function (card) {
            var name = card.getAttribute('name').toUpperCase();
            if (name.indexOf(value) > -1) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }

        });

    });

    $('#DateStartSearch').on('change', function () {
        var startDate = $(this).val();
        if (startDate) {
            $('#DateEndSearch').attr('min', startDate);
            $('#DateEndSearch').val('');
            $('#DateEndSearch').toggleClass('required');
        } else {
            $('#DateEndSearch').removeAttr('min');
        }
    });

    $('#menu-primarymenuar li a').click(function () {
        $('#menu-primarymenuar li a').removeClass('active');
        $(this).addClass('active');
    });


    jQuery(document).on("click", ".wrapper-menu", function () {
        jQuery(this).toggleClass("open");
    });

    jQuery(document).on("click", ".wrapper-menu", function () {
        jQuery("body").toggleClass("sidebar-main");
    });


    jQuery(".close-toggle").on("click", function () {
        jQuery(".h-collapse.navbar-collapse").collapse("hide");
    });

    $(window).scroll(function () {
        $('section').each(function () {
            var top_of_element = $(this).offset().top;
            var bottom_of_element = $(this).offset().top + $(this).outerHeight();
            var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
            var top_of_screen = $(window).scrollTop();
            var id = $(this).attr('id');

            if ((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element)) {
                $('#menu-primarymenuar li a').removeClass('active');
                $('#menu-primarymenuar li.' + id + ' a').addClass('active');
            }
        });
    });

    var requiredInputs = document.querySelectorAll('.required');
    requiredInputs.forEach(function (input) {
        input.addEventListener('keyup', function () {
            if (input.value.trim() === '') {
                input.classList.add('input-error');
            } else {
                input.classList.remove('input-error');
            }
        });
    });

    $('.ExportTable').on('click', function () {
        $('.hidewhenexport').hide();
        var id = $(this).attr('tableid');
        var filename = $(this).attr('filename');
        var table = document.getElementById(id);
        var ws = XLSX.utils.table_to_sheet(table, { display: true });
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
        XLSX.writeFile(wb, filename + ".xlsx");
        $('.hidewhenexport').show();
    });


    class BackIcon extends HTMLElement {
        constructor() {
            super();
        }
    }
    customElements.define('back-icon', BackIcon);
    class BackCIcon extends HTMLElement {
        constructor() {
            super();
        }
    }
    customElements.define('back-c-icon', BackCIcon);
    class ForwarCIcon extends HTMLElement {
        constructor() {
            super();
        }
    }
    customElements.define('front-c-icon', ForwarCIcon);


    
    if (lang == 'ar') {
        $('back-icon').html(
            `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>`
        );
        $('front-c-icon').html(
            `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2ZM12 20C16.42 20 20 16.42 20 12C20 7.58 16.42 4 12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20ZM12 11H16V13H12V16L8 12L12 8V11Z"></path></svg>`
        );
        $('back-c-icon').html(
            `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 11V8L16 12L12 16V13H8V11H12ZM12 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2ZM12 20C16.42 20 20 16.42 20 12C20 7.58 16.42 4 12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20Z"></path></svg>`
        );
    } else {
        $('back-icon').html(
            `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z"></path></svg>`
        );
        $('front-c-icon').html(
            `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 11V8L16 12L12 16V13H8V11H12ZM12 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2ZM12 20C16.42 20 20 16.42 20 12C20 7.58 16.42 4 12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20Z"></path></svg>`
        );
        $('back-c-icon').html(
            `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2ZM12 20C16.42 20 20 16.42 20 12C20 7.58 16.42 4 12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20ZM12 11H16V13H12V16L8 12L12 8V11Z"></path></svg>`
        );
    }

});





function myFunction(startCol, columnsToSearch) {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = startCol; i < tr.length; i++) {
        tr[i].style.display = "";
        var isTextFound = false;
        for (j = 0; j < columnsToSearch.length; j++) {
            td = tr[i].getElementsByTagName("td")[columnsToSearch[j]];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    isTextFound = true;
                    break;
                }
            }
        }

        if (isTextFound) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}

