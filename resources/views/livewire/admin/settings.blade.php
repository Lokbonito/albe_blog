<div>
    <div class="tab">
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
                <a wire:click="selectTab('general_settings')"
                    class="nav-link {{ $tab == 'general_settings' ? 'active' : '' }}" data-toggle="tab"
                    href="#general_settings" role="tab" aria-selected="true">Cài đặt chung</a>
            </li>
            <li class="nav-item">
                <a wire:click="selectTab('logo_favicon')" class="nav-link {{ $tab == 'logo_favicon' ? 'active' : '' }}"
                    data-toggle="tab" href="#logo_favicon" role="tab" aria-selected="false">Logo &
                    Favicon</a>
            </li>
            <li class="nav-item">
                <a wire:click="selectTab('social_links')" class="nav-link {{ $tab == 'social_links' ? 'active' : '' }}"
                    data-toggle="tab" href="#social_links" role="tab" aria-selected="true">Social Links</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade {{ $tab == 'general_settings' ? 'active show' : '' }}" id="general_settings"
                role="tabpanel">
                <div class="pd-20">
                    <form wire:submit="updateSiteInfo()">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Tiêu đề Site</b></label>
                                    <input type="text" class="form-control" wire:model="site_title"
                                        placeholder="Enter Site Title">
                                    @error('site_title')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site Email</b></label>
                                    <input type="text" class="form-control" wire:model="site_email"
                                        placeholder="Enter Site Email">
                                    @error('site_email')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Số điện thoại site</b><small>(Tùy chọn)</small></label>
                                    <input type="text" class="form-control" wire:model="site_phone"
                                        placeholder="Enter Site Phone">
                                    @error('site_phone')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Từ khóa Site Meta</b><small>(Tùy chọn)</small></label>
                                    <input type="text" class="form-control" wire:model="site_meta_keywords"
                                        placeholder="Enter Site Meta Keywords">
                                    @error('site_meta_keywords')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for=""><b>Mô tả Site Meta </b><small>(Tùy chọn)</small></label>
                            <textarea class="form-control" cols="4" rows="4" placeholder="Type site meta Description"
                                wire:model="site_meta_description"></textarea>
                            @error('site_meta_description')
                                <span class="text-danger ml-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">Lưu</button>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade {{ $tab == 'logo_favicon' ? 'active show' : '' }}" id="logo_favicon"
                role="tabpanel">
                <div class="pd-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Site Logo</h6>
                            <div class="mb-2 mt-1" style="max-width: 200px">
                                <img wire:ignore src="" alt="" class="img-thumbnail"
                                    data-ijabo-default-img="/images/site/{{ isset(settings()->site_logo) ? settings()->site_logo : '' }}"
                                    id="preview_site_logo">
                                <form action="{{ route('admin.update_logo') }}" method="post"
                                    enctype="multipart/form-data" id="updateLogoForm">
                                    @csrf
                                    <div class="mb-2">
                                        <input type="file" name="site_logo" id="" class="form_control">
                                        <span class="text-danger ml-1"></span>
                                    </div>
                                    <button type="submit" class="btn btn-success">Thay đổi logo</button>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6>Site Favicon</h6>
                            <div class="mb-2 mt-1" style="max-width: 100px">
                                <img wire:ignore src="" alt="" class="img-thumbnail"
                                    data-ijabo-default-img="/images/site/{{ isset(settings()->site_favicon) ? settings()->site_favicon : '' }}"
                                    id="preview_site_favicon">
                            </div>
                            <form action="{{ route('admin.update_favicon') }}" method="post"
                                enctype="multipart/form-data" id="updateFaviconForm">
                                @csrf
                                <div class="mb-2">
                                    <input type="file" name="site_favicon" id="" class="form-control">
                                    <span class="text-danger ml-1"></span>
                                </div>

                                <button type="submit" class="btn btn-success">Thay đổi Favicon</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade {{ $tab == 'social_links' ? 'active show' : '' }}" id="social_links"
                role="tabpanel">
                <div class="pd-20">
                    <form wire:submit="updateSiteSocialLinks()">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for=""><b>Facebook</b>:</label>
                                    <input type="text" wire:model="facebook_url" class="form-control" placeholder="Facebook Url">
                                    @error('facebook_url')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for=""><b>Instagram</b>:</label>
                                    <input type="text" wire:model="instagram_url" class="form-control" placeholder="Instagram Url">
                                    @error('instagram_url')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for=""><b>Youtube</b>:</label>
                                    <input type="text" wire:model="youtube_url" class="form-control" placeholder="Youtube Url">
                                    @error('youtube_url')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for=""><b>Twitter</b>:</label>
                                    <input type="text" wire:model="twitter" class="form-control" placeholder="Twitter Url">
                                    @error('twitter')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success" type="submit">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
