<?php

namespace App\Http\Controllers;

use App\Models\PublicPageSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminPublicController extends Controller
{
    public function edit()
    {
        return view('admin.public.edit', [
            'content' => PublicPageSetting::getContent(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:2000',
            'about_title' => 'required|string|max:255',
            'about_paragraph_1' => 'required|string|max:3000',
            'about_paragraph_2' => 'required|string|max:3000',
            'about_paragraph_3' => 'required|string|max:3000',
            'stat_1_number' => 'required|string|max:50',
            'stat_1_label' => 'required|string|max:120',
            'stat_2_number' => 'required|string|max:50',
            'stat_2_label' => 'required|string|max:120',
            'stat_3_number' => 'required|string|max:50',
            'stat_3_label' => 'required|string|max:120',
            'stat_4_number' => 'required|string|max:50',
            'stat_4_label' => 'required|string|max:120',
            'features_title' => 'required|string|max:255',
            'features_subtitle' => 'required|string|max:2000',
            'feature_1_title' => 'required|string|max:120',
            'feature_1_text' => 'required|string|max:500',
            'feature_2_title' => 'required|string|max:120',
            'feature_2_text' => 'required|string|max:500',
            'feature_3_title' => 'required|string|max:120',
            'feature_3_text' => 'required|string|max:500',
            'feature_4_title' => 'required|string|max:120',
            'feature_4_text' => 'required|string|max:500',
            'footer_brand_name' => 'required|string|max:120',
            'footer_brand_text' => 'required|string|max:1000',
            'contact_address' => 'required|string|max:500',
            'contact_email' => 'required|email|max:255',
            'business_hours_1' => 'required|string|max:120',
            'business_hours_2' => 'required|string|max:120',
            'business_hours_3' => 'required|string|max:120',
            'store_logo' => 'nullable|image|max:4096',
            'hero_image' => 'nullable|image|max:4096',
            'about_image' => 'nullable|image|max:4096',
        ]);

        $setting = PublicPageSetting::query()->firstOrCreate([], [
            'content' => PublicPageSetting::defaults(),
        ]);

        $content = array_merge(PublicPageSetting::defaults(), $setting->content ?? [], $validated);

        foreach (['store_logo', 'hero_image', 'about_image'] as $imageKey) {
            if ($request->hasFile($imageKey)) {
                $content[$imageKey] = $request->file($imageKey)->store('public-page', 'public');
            }
        }

        $setting->update(['content' => $content]);

        return back()->with('success', 'Public page content updated successfully.');
    }

    public function editOthers()
    {
        $content = PublicPageSetting::getContent();

        return view('admin.public.others', [
            'others' => $content['others'] ?? PublicPageSetting::othersDefaults(),
        ]);
    }

    public function updateOthers(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'contact' => 'required|array',
            'about' => 'required|array',
            'faq' => 'required|array',
            'privacy' => 'required|array',
        ]);

        $setting = PublicPageSetting::query()->firstOrCreate([], [
            'content' => PublicPageSetting::defaults(),
        ]);

        $base = array_replace_recursive(PublicPageSetting::defaults(), $setting->content ?? []);
        $mergedOthers = array_replace_recursive(
            PublicPageSetting::othersDefaults(),
            $base['others'] ?? [],
            [
                'contact' => $this->sanitizeArray($validated['contact']),
                'about' => $this->sanitizeArray($validated['about']),
                'faq' => $this->sanitizeArray($validated['faq']),
                'privacy' => $this->sanitizeArray($validated['privacy']),
            ]
        );

        $base['others'] = $mergedOthers;
        $setting->update(['content' => $base]);

        return back()->with('success', 'Other public pages updated successfully.');
    }

    public function editIncubation()
    {
        $content = PublicPageSetting::getContent();
        $defaults = PublicPageSetting::othersDefaults()['incubation_page'] ?? [];
        $incubation = array_replace_recursive($defaults, $content['others']['incubation_page'] ?? []);

        return view('admin.public.incubation', [
            'incubation' => $incubation,
        ]);
    }

    public function updateIncubation(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'eyebrow' => 'required|string|max:120',
            'title' => 'required|string|max:255',
            'details_title' => 'required|string|max:255',
            'details_text' => 'required|string|max:3000',
            'why_title' => 'required|string|max:255',
            'book_button' => 'required|string|max:120',
            'services' => 'required|array|size:4',
            'services.*.badge' => 'required|string|max:80',
            'services.*.title' => 'required|string|max:255',
            'services.*.description' => 'required|string|max:2000',
            'services.*.price' => 'required|string|max:50',
            'services.*.price_note' => 'required|string|max:120',
            'services.*.rating' => 'required|string|max:10',
            'services.*.reviews' => 'required|string|max:20',
            'factors' => 'required|array|size:8',
            'factors.*.icon' => 'required|string|max:80',
            'factors.*.title' => 'required|string|max:150',
            'factors.*.description' => 'required|string|max:500',
            'why_items' => 'required|array|min:3|max:8',
            'why_items.*' => 'nullable|string|max:255',
            'service_images' => 'nullable|array',
            'service_images.*' => 'nullable|image|max:4096',
        ]);

        $setting = PublicPageSetting::query()->firstOrCreate([], [
            'content' => PublicPageSetting::defaults(),
        ]);

        $base = array_replace_recursive(PublicPageSetting::defaults(), $setting->content ?? []);
        $incubation = $base['others']['incubation_page'] ?? (PublicPageSetting::othersDefaults()['incubation_page'] ?? []);

        $whyItems = array_values(array_filter(
            array_map(fn ($v) => trim((string) $v), $validated['why_items']),
            fn ($v) => $v !== ''
        ));

        if (count($whyItems) < 3) {
            return back()->withErrors(['why_items' => 'Please provide at least 3 "Why choose us" items.'])->withInput();
        }

        $incubation = array_replace_recursive($incubation, [
            'eyebrow' => trim($validated['eyebrow']),
            'title' => trim($validated['title']),
            'details_title' => trim($validated['details_title']),
            'details_text' => trim($validated['details_text']),
            'why_title' => trim($validated['why_title']),
            'book_button' => trim($validated['book_button']),
            'services' => $this->sanitizeArray($validated['services']),
            'factors' => $this->sanitizeArray($validated['factors']),
            'why_items' => $whyItems,
        ]);

        foreach ($request->file('service_images', []) as $idx => $img) {
            if ($img) {
                $incubation['services'][$idx]['image'] = $img->store('public-page/incubation', 'public');
            }
        }

        $base['others']['incubation_page'] = $incubation;
        $setting->update(['content' => $base]);

        return back()->with('success', 'Incubation page details updated successfully.');
    }

    private function sanitizeArray(array $input): array
    {
        $out = [];
        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $out[$key] = $this->sanitizeArray($value);
            } else {
                $out[$key] = trim((string) $value);
            }
        }

        return $out;
    }
}
