@extends('web.layouts.master')
@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-lg-6">
        <div class="card shadow-lg p-4">
            <h3 class="text-center mb-3">Create Your Account</h3>

            <form id="form_register" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="name" class="form-label">Username</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="john_doe" required>
                    </div>
                    <div class="col-md-12">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@mail.com" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirm" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirmation" placeholder="********" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="(123) 456-7890">
                    </div>
                    <div class="col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="123 Main St">
                    </div>
                    <div class="col-md-6">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="avatar" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="agree_terms" name="agree_terms" value="1" required>
                            <label class="form-check-label" for="agree_terms">I accept all terms and conditions</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" id="registerBtn" class="btn btn-primary w-100">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
$(document).ready(function() {
    $('#form_register').submit(function(e) {
        e.preventDefault();

        if (!$('#agree_terms').prop('checked')) {
            Swal.fire("Error", "You must accept all terms and conditions!", "error");
            return;
        }

        if ($('#password').val() !== $('#password_confirm').val()) {
            Swal.fire("Error", "Passwords do not match!", "error");
            return;
        }

        var formData = new FormData(this);
        formData.append('status', 1);
        formData.append('is_admin', 0);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('web.register.store') }}",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                Swal.fire({
                    title: "Success",
                    text: "Registration successful! Redirecting to login...",
                    icon: "success",
                    timer: 2000, // Chờ 2 giây rồi chuyển trang
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('web.login') }}"; 
                });
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                var errorMessage = xhr.responseJSON?.message || "Registration failed!";
                Swal.fire("Error", errorMessage, "error");
            }
        });
    });
});

</script>

@endsection
