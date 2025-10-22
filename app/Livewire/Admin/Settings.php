<?php

namespace App\Livewire\Admin;

use App\Models\GeneralSetting;
use Livewire\Component;
use App\Models\SiteSocialLink;

class Settings extends Component
{
    public $tab = null;
    public $default_tab = 'general_settings';

    protected $queryString = ['tab' => ['keep' => true]];

    // General Settings
    public $site_title, $site_email, $site_phone, $site_meta_keywords, $site_meta_description;

    // Site social link form properties
    public $facebook_url, $instagram_url, $youtube_url, $twitter_url;

    public function selectTab($tab)
    {
        $this->tab = $tab;
    }

    public function mount()
    {
        $this->tab = Request('tab') ? Request('tab') : $this->default_tab;
        // Populate General Settings
        $settings = GeneralSetting::take(1)->first();
        // Populate Site Social Link
        $site_social_links = SiteSocialLink::take(1)->first();
        if (!is_null($settings)) {
            $this->site_title = $settings->site_title;
            $this->site_email = $settings->site_email;
            $this->site_phone = $settings->site_phone;
            $this->site_meta_keywords = $settings->site_meta_keywords;
            $this->site_meta_description = $settings->site_meta_description;
        }

        if (!is_null($site_social_links)) {
            $this->facebook_url = $site_social_links->facebook_url;
            $this->instagram_url = $site_social_links->instagram_url;
            $this->youtube_url = $site_social_links->youtube_url;
            $this->twitter_url = $site_social_links->twitter_url;
        }
    }

    public function updateSiteInfo()
    {
        $this->validate([
            'site_title' => 'required',
            'site_email' => 'required|email',
        ], [
            'site_title.required' => 'Vui lòng nhập tiêu đề trang.',
            'site_email.required' => 'Vui lòng nhập email trang.',
            'site_email.email' => 'Địa chỉ email không hợp lệ.',
        ]);


        $settings = GeneralSetting::take(1)->first();

        $data = [
            'site_title' => $this->site_title,
            'site_email' => $this->site_email,
            'site_phone' => $this->site_phone,
            'site_meta_keywords' => $this->site_meta_keywords,
            'site_meta_description' => $this->site_meta_description
        ];

        if (!is_null($settings)) {
            $query = $settings->update($data);
        } else {
            $query = GeneralSetting::insert($data);
        }

        if ($query) {
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Cài đặt chung cập nhật thành công']);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Có lỗi xảy ra']);
        }
    }

    public function updateSiteSocialLinks()
    {
        $this->validate([
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
        ], [
            'facebook_url.url' => 'Đường dẫn Facebook không hợp lệ.',
            'instagram_url.url' => 'Đường dẫn Instagram không hợp lệ.',
            'youtube_url.url' => 'Đường dẫn YouTube không hợp lệ.',
            'twitter_url.url' => 'Đường dẫn Twitter không hợp lệ.',
        ]);


        $site_social_links = SiteSocialLink::take(1)->first();

        $data = array(
            'facebook_url' => $this->facebook_url,
            'instagram_url' => $this->instagram_url,
            'youtube_url' => $this->youtube_url,
            'twitter_url' => $this->twitter_url
        );

        if (!is_null($site_social_links)) {
            $query = $site_social_links->update($data);
        } else {
            $query = SiteSocialLink::create($data);
        }

        if ($query) {
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Đường dẫn mạng xã hội cập nhật thành công']);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Có lỗi xảy ra']);
        }
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
