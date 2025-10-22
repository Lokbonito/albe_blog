<div>
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
            <div class="pd-20 card-box height-100-p">
                <div class="profile-photo">
                    <a href="javascript:;"
                        onclick="event.preventDefault();document.getElementById('profilePictureFile').click();"
                        class="edit-avatar"><i class="fa fa-pencil"></i></a>
                    <img src="{{ $user->picture }}" alt="" class="avatar-photo" id="profilePicturePreview">
                    <input type="file" name="profilePictureFile" id="profilePictureFile" class="d-none"
                        style="opacity:0">
                </div>
                <h5 class="text-center h5 mb-0">{{ $user->name }}</h5>
                <p class="text-center text-muted font-14">
                    {{ $user->email }}
                </p>

            </div>
        </div>
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
            <div class="card-box height-100-p overflow-hidden">
                <div class="profile-tab height-100-p">
                    <div class="tab height-100-p">
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item">
                                <a wire:click="selectTab('personal_details')"
                                    class="nav-link {{ $tab == 'personal_details' ? 'active' : '' }}" data-toggle="tab"
                                    href="#personal_details" role="tab">Thông tin tài khoản</a>
                            </li>
                            <li class="nav-item">
                                <a wire:click="selectTab('update_password')"
                                    class="nav-link {{ $tab == 'update_password' ? 'active' : '' }}" data-toggle="tab"
                                    href="#update_password" role="tab">Cập nhật mật khẩu</a>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <!-- Personal Details Tab start -->
                            <div class="tab-pane fade {{ $tab == 'personal_details' ? 'show active' : '' }}"
                                id="personal_details" role="tabpanel">
                                <div class="pd-20">
                                    <form wire:submit.prevent="updatePersonalDetail()">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Tên người dùng</label>
                                                    <input type="text" class="form-control" wire:model="name"
                                                        placeholder="Enter your full name">
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input type="text" class="form-control" wire:model="email"
                                                        placeholder="Enter your email" disabled>
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Tên đăng nhập</label>
                                                    <input type="text" class="form-control" wire:model="username"
                                                        placeholder="Enter your username">
                                                    @error('username')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-grop">
                                                    <label for="">Bio</label>
                                                    <textarea name="" id="" wire:model="bio" cols="4" rows="4" class="form-control"
                                                        placeholder="Type your bio..."></textarea>
                                                    @error('bio')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mt-4">
                                            <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="updatePersonalDetail">Lưu</span>
                                                <span wire:loading wire:target="updatePersonalDetail">Đang lưu...</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Personal Details Tab End -->

                            <!-- Update Password Tab start -->
                            <div class="tab-pane fade {{ $tab == 'update_password' ? 'show active' : '' }}"
                                id="update_password" role="tabpanel">
                                <div class="pd-20 profile-task-wrap">
                                
                                    @if (!$showOtpInput)
                                        {{-- Bước 1: Form nhập mật khẩu --}}
                                        <form wire:submit.prevent="sendUpdatePasswordOtp()">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Mật khẩu hiện tại</label>
                                                        <input type="password" class="form-control" wire:model.defer="current_password" placeholder="Nhập mật khẩu hiện tại">
                                                        @error('current_password')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Mật khẩu mới</label>
                                                        <input type="password" class="form-control" wire:model.defer="new_password" placeholder="Nhập mật khẩu mới">
                                                        @error('new_password')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Xác nhận lại mật khẩu mới</label>
                                                        <input type="password" class="form-control" wire:model.defer="new_password_confirmation" placeholder="Xác nhận mật khẩu mới">
                                                        @error('new_password_confirmation')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="sendUpdatePasswordOtp">Gửi mã xác thực</span>
                                                <span wire:loading wire:target="sendUpdatePasswordOtp">Đang gửi...</span>
                                            </button>
                                        </form>
                                    @else
                                        {{-- Bước 2: Form nhập OTP --}}
                                        <form wire:submit.prevent="updatePassword()">
                                            <p>Một mã OTP đã được gửi đến email <b>{{ $email }}</b>. Vui lòng kiểm tra và nhập mã vào ô bên dưới để hoàn tất.</p>
                                            <div class="form-group">
                                                <label for="otp">Mã OTP</label>
                                                <input type="text" class="form-control" id="otp" wire:model.defer="otp" placeholder="Nhập mã OTP gồm 6 chữ số">
                                                @error('otp')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                                    <span wire:loading.remove wire:target="updatePassword">Xác nhận và Cập nhật</span>
                                                    <span wire:loading wire:target="updatePassword">Đang xử lý...</span>
                                                </button>
                                                <button type="button" class="btn btn-secondary" wire:click="resetForm()" wire:loading.attr="disabled" wire:target="updatePassword">Hủy</button>
                                            </div>
                                        </form>
                                    @endif

                                </div>
                            </div>
                            <!-- Update Password Tab End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

