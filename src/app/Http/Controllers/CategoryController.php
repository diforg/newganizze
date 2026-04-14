<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(Request $request): Response
    {
        $activeTab = $request->string('type')->toString();
        $activeTab = in_array($activeTab, ['expense', 'income'], true) ? $activeTab : 'expense';

        $categories = Category::with('children')
            ->roots()
            ->active()
            ->where(function ($query) use ($activeTab): void {
                $query->where('nature', $activeTab)
                    ->orWhere('nature', 'both');
            })
            ->orderBy('name')
            ->get();

        $archivedCount = Category::roots()
            ->archived()
            ->where(function ($query) use ($activeTab): void {
                $query->where('nature', $activeTab)
                    ->orWhere('nature', 'both');
            })
            ->count();

        return Inertia::render('Categories/Index', compact('categories', 'archivedCount', 'activeTab'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'nature'             => 'required|in:income,expense,both',
            'icon'               => 'required|string|max:50',
            'color'              => 'required|string|size:7',
            'parent_category_id' => 'nullable|integer|exists:categories,id',
            'archived'           => 'boolean',
        ]);

        if (!empty($validated['parent_category_id'])) {
            $parent = Category::findOrFail($validated['parent_category_id']);

            if ($parent->parent_category_id !== null) {
                abort(422, 'Max depth exceeded');
            }
        }

        Category::create($validated);

        return to_route('categories.index', ['type' => $request->query('type', 'expense')]);
    }
}