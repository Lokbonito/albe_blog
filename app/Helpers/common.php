<?php

use App\Models\GeneralSetting;
use App\Models\ParentCategory;
use App\Models\Category;
use App\Models\Post;
use App\Models\Slide;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\SiteSocialLink;


if (!function_exists('settings')) {
    function settings()
    {
        $settings = GeneralSetting::take(1)->first();

        if (!is_null($settings)) {
            return $settings;
        }
    }
}

// Site social links
if (!function_exists('site_social_links')) {
    function site_social_links()
    {
        $links = SiteSocialLink::take(1)->first();
        if (!is_null($links)) {
            return $links;
        }
    }
}

if (!function_exists('navigations')) {
    function navigations()
    {
        $navigations_html = '';

        // With dropdown
        $pcategories = ParentCategory::whereHas('children', function ($q) {
            $q->whereHas('posts');
        })->orderBy('name', 'asc')->get();

        // Without dropdown
        $categories = Category::whereHas('posts')->where('parent', 0)->orderBy('name', 'asc')->get();

        if (count($pcategories) > 0) {
            foreach ($pcategories as $item) {
                $navigations_html .= '
                    <div class="relative group">
                        <button
                            class="font-medium inline-flex items-center gap-1 py-2 hover:text-[#43b14b] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#43b14b]/40 rounded-lg uppercase whitespace-nowrap"
                            aria-haspopup="true">
                            ' . $item->name . '
                            <svg class="h-4 w-4 transition-transform duration-200 group-hover:rotate-180"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.24 4.5a.75.75 0 01-1.08 0l-4.24-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div
                            class="absolute left-0 top-full pt-2 z-30 pointer-events-none opacity-0 translate-y-1 transition-all duration-200 ease-out group-hover:pointer-events-auto group-hover:opacity-100 group-hover:translate-y-0">
                            <div
                                class="min-w-[260px] bg-white border border-slate-200 border-t-2 border-t-green-400 shadow-xl ring-1 ring-black/5 p-2 text-sm rounded-lg">
                ';

                foreach ($item->children as $category) {
                    if ($category->posts->count() > 0) {
                        $navigations_html .= '
                            <a href="' . route('category_posts', $category->slug) . '"
                                    class="block px-3 py-2 font-medium text-slate-500 hover:text-[#43b14b] border-b border-b-gray-200 normal-case">' . $category->name . '</a>
                        ';
                    }
                }

                $navigations_html .= '
                            </div>
                        </div>
                    </div>
                ';
            }
        }

        if (count($categories) > 0) {
            foreach ($categories as $item) {
                $navigations_html .= '
                        <a class="hover:text-brand-600 font-medium hover:text-[#43b14b]" href="' . route('category_posts', $item->slug) . '">' . $item->name . '</a>
                ';
            }
        }

        return $navigations_html;
    }
}

if (!function_exists('appdevs_dropdown')) {
    function appdevs_dropdown()
    {
        $html = '';

        // Lấy parent category có tên APP DEVS
        $appDevs = ParentCategory::where('name', 'DỊCH VỤ')
            ->whereHas('children', function ($q) {
                $q->whereHas('posts');
            })
            ->first();

        if ($appDevs) {
            $html .= '
                <div class="relative group">
                    <button
                        class="font-medium inline-flex items-center gap-1 py-2 hover:text-[#43b14b] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#43b14b]/40 rounded-lg uppercase whitespace-nowrap"
                        aria-haspopup="true">
                        ' . $appDevs->name . '
                        <svg class="h-4 w-4 transition-transform duration-200 group-hover:rotate-180"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.24 4.5a.75.75 0 01-1.08 0l-4.24-4.5a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div
                        class="absolute left-0 top-full pt-2 z-30 pointer-events-none opacity-0 translate-y-1 transition-all duration-200 ease-out group-hover:pointer-events-auto group-hover:opacity-100 group-hover:translate-y-0">
                        <div
                            class="min-w-[260px] bg-white border border-slate-200 border-t-2 border-t-green-400 shadow-xl ring-1 ring-black/5 p-2 text-sm rounded-lg">
            ';

            foreach ($appDevs->children as $category) {
                if ($category->posts->count() > 0) {
                    $html .= '
                        <a href="' . route('category_posts', $category->slug) . '"
                            class="block px-3 py-2 font-medium text-slate-500 hover:text-[#43b14b] border-b border-b-gray-200 normal-case">'
                        . $category->name .
                        '</a>';
                }
            }

            $html .= '
                        </div>
                    </div>
                </div>
            ';
        }

        return $html;
    }
}

if (!function_exists('webtutorials_dropdown')) {
    function webtutorials_dropdown()
    {
        $html = '';

        // Lấy parent category có tên WEB TUTORIALS
        $webTutorials = ParentCategory::where('name', 'KIẾN THỨC')
            ->whereHas('children', function ($q) {
                $q->whereHas('posts');
            })
            ->first();

        if ($webTutorials) {
            $html .= '
                <div class="relative group">
                    <button
                        class="font-medium inline-flex items-center gap-1 py-2 hover:text-[#43b14b] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#43b14b]/40 rounded-lg uppercase whitespace-nowrap"
                        aria-haspopup="true">
                        ' . $webTutorials->name . '
                        <svg class="h-4 w-4 transition-transform duration-200 group-hover:rotate-180"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.24 4.5a.75.75 0 01-1.08 0l-4.24-4.5a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div
                        class="absolute left-0 top-full pt-2 z-30 pointer-events-none opacity-0 translate-y-1 transition-all duration-200 ease-out group-hover:pointer-events-auto group-hover:opacity-100 group-hover:translate-y-0">
                        <div
                            class="min-w-[260px] bg-white border border-slate-200 border-t-2 border-t-green-400 shadow-xl ring-1 ring-black/5 p-2 text-sm rounded-lg">
            ';

            foreach ($webTutorials->children as $category) {
                if ($category->posts) {
                    $html .= '
                        <a href="' . route('category_posts', $category->slug) . '"
                            class="block px-3 py-2 font-medium text-slate-500 hover:text-[#43b14b] border-b border-b-gray-200 normal-case">'
                        . $category->name .
                        '</a>';
                }
            }

            $html .= '
                        </div>
                    </div>
                </div>
            ';
        }

        return $html;
    }
}

if (!function_exists('flutter_link')) {
    function flutter_link()
    {
        return '
            <a href="' . route('category_posts', 'ĐÀO TẠO') . '"
               class="font-medium inline-flex items-center gap-1 py-2 hover:text-[#43b14b] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#43b14b]/40 rounded-lg whitespace-nowrap">
               ĐÀO TẠO
            </a>
        ';
    }
}

if (!function_exists('date_formatter')) {
    function date_formatter($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->isoFormat('LL');
    }
}

if (!function_exists('words')) {
    function words($value, $words = 15, $end = '...')
    {
        return Str::words(strip_tags($value), $words, $end);
    }
}

/**
 * CALCULATE POST READING DURATION
 */
if (!function_exists('readDuration')) {
    function readDuration(...$text)
    {
        Str::macro('timeCounter', function ($text) {
            $totalWords = str_word_count(implode(" ", $text));
            $minutesToRead = round($totalWords / 200);
            return (int)max(1, $minutesToRead);
        });
        return Str::timeCounter($text);
    }
}

/**
 * DISPLAY LATEST POST ON HOMEPAGE
 */
if (!function_exists('latest_posts')) {
    function latest_posts($skip = 0, $limit = 10)
    {
        return Post::skip($skip)
            ->limit($limit)
            ->where('visibility', 1)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}

if (!function_exists('getTags')) {
    function getTags($limit = null)
    {
        $tags = Post::where('tags', '!=', '')->pluck('tags');

        $uniqueTags = $tags->flatMap(function ($tagsString) {
            return explode(',', $tagsString);
        })->map(fn($tag) => trim($tag))
            ->unique()
            ->sort()
            ->values();

        if ($limit) {
            $uniqueTags = $uniqueTags->take($limit);
        }
        return $uniqueTags->all();
    }
}

if (!function_exists('get_slides')) {
    function get_slides($limit = 5)
    {
        return Slide::where('status', 1)
            ->limit($limit)
            ->orderBy('ordering', 'asc')
            ->get();
    }
}
