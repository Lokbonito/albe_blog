<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ParentCategory;
use App\Models\Category;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;
    public $isUpdateParentCategoryMode = false;
    public $pcategory_id, $pcategory_name;

    public $isUpdateCategoryMode = false;
    public $category_id, $parent = 0, $category_name;

    public $pcategoriesPerPage = 3;
    public $categoriesPerPage = 10;

    protected $listeners = [
        'updateParentCategoryOrdering',
        'updateCategoryOrdering',
        'deleteParentCategoryAction',
        'deleteCategoryAction'
    ];

    public function addParentCategory()
    {
        $this->pcategory_id = null;
        $this->pcategory_name = null;
        $this->isUpdateParentCategoryMode = false;
        $this->showParentCategoryModalForm();
    }

    public function createParentCategory()
    {
        $this->validate([
            'pcategory_name' => 'required|unique:parent_categories,name'
        ], [
            'pcategory_name.required' => 'Yêu cầu nhập tên thể loại cha',
            'pcategory_name.unique' => 'Tên thể loại cha đã tồn tại'
        ]);

        $pcategory = new ParentCategory();
        $pcategory->name = $this->pcategory_name;
        $saved = $pcategory->save();

        if ($saved) {
            $this->hideParentCategoryModalForm();
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Thể loại cha mới đã được thêm thành công']);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Có lỗi xảy ra']);
        }
    }

    public function editParentCategory($id)
    {
        $pcategory = ParentCategory::findOrFail($id);
        $this->pcategory_id = $pcategory->id;
        $this->pcategory_name = $pcategory->name;
        $this->isUpdateParentCategoryMode = true;
        $this->showParentCategoryModalForm();
    }

    public function updateParentCategory()
    {
        $pcategory = ParentCategory::findOrFail($this->pcategory_id);

        $this->validate([
            'pcategory_name' => 'required|unique:parent_categories,name,' . $pcategory->id
        ], [
            'pcategory_name.required' => 'Yêu cầu nhập tên thể loại cha',
            'pcategory_name.unique' => 'Tên thể loại cha đã tồn tại'
        ]);

        $pcategory->name = $this->pcategory_name;
        $pcategory->slug = null;
        $updated = $pcategory->save();

        if ($updated) {
            $this->hideParentCategoryModalForm();
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Thể loại cha mới đã được thêm thành công']);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Có lỗi xảy ra']);
        }
    }

    public function updateParentCategoryOrdering($positions)
    {
        foreach ($positions as $position) {
            $index = $position[0];
            $new_position = $position[1];
            ParentCategory::where('id', $index)->update([
                'ordering' => $new_position
            ]);
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Thứ tự của thể loại cha đã được cập nhật thành công']);
        }
    }

    public function updateCategoryOrdering($positions)
    {
        foreach ($positions as $position) {
            $index = $position[0];
            $new_position = $position[1];
            Category::where('id', $index)->update([
                'ordering' => $new_position
            ]);
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Thứ tự của thể loại đã được cập nhật thành công']);
        }
    }

    public function deleteCategory($id)
    {
        $this->dispatch('deleteCategory', ['id' => $id]);
    }

    public function deleteCategoryAction($id)
    {
        $category = Category::findOrFail($id);

        if ($category->posts->count() > 0) {
            $count = $category->posts->count();
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Thể loại này có (' . $count . ') bài viết liên quan. Không thể xóa']);
        } else {
            $delete = $category->delete();

            if ($delete) {
                $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Thể loại đã được xóa thành công']);
            } else {
                $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Xóa thành công']);
            }
        }
    }

    public function deleteParentCategory($id)
    {
        $this->dispatch('deleteParentCategory', ['id' => $id]);
    }

    public function deleteParentCategoryAction($id)
    {
        $pcategory = ParentCategory::findOrFail($id);

        if ($pcategory->children->count() > 0) {
            foreach ($pcategory->children as $category) {
                Category::where('id', $category->id)->update(['parent' => 0]);
            }
        }

        $delete = $pcategory->delete();
        if ($delete) {
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Thể loại cha đã được xóa thành công']);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Có lỗi xảy ra']);
        }
    }

    public function addCategory()
    {
        $this->category_id = null;
        $this->parent = 0;
        $this->category_name = null;
        $this->showCategoryModalForm();
    }

    public function createCategory()
    {
        $this->validate([
            'category_name' => 'required|unique:categories,name'
        ], [
            'category_name.required' => 'Yêu cầu nhập tên thể loại',
            'category_name.unique' => 'Tên thể loại đã tồn tại'
        ]);

        $category = new Category();
        $category->parent = $this->parent;
        $category->name = $this->category_name;
        $saved = $category->save();

        if ($saved) {
            $this->hideCategoryModalForm();
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Thể loại mới đã được thêm thành công']);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Có lỗi xảy ra.']);
        }
    }

    public function editCategory($id)
    {
        $category  = Category::findOrFail($id);
        $this->category_id = $category->id;
        $this->parent = $category->parent;
        $this->category_name = $category->name;
        $this->isUpdateCategoryMode = true;
        $this->showCategoryModalForm();
    }

    public function updateCategory()
    {
        $category = Category::findOrFail($this->category_id);
        $this->validate([
            'category_name' => 'required|unique:categories,name,' . $category->id,
        ], [
            'category_name.required' => 'Yêu cầu nhập tên thể loại',
            'category_name.unique' => 'Tên thể loại đã tồn tại'
        ]);

        $category->name = $this->category_name;
        $category->parent = $this->parent;
        $category->slug = null;
        $updated = $category->save();

        if ($updated) {
            $this->hideCategoryModalForm();
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Thể loại đã được cập nhật thành công']);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Có lỗi xảy ra']);
        }
    }

    public function showParentCategoryModalForm()
    {
        $this->resetErrorBag();
        $this->dispatch('showParentCategoryModalForm');
    }

    public function hideParentCategoryModalForm()
    {
        $this->dispatch('hideParentCategoryModalForm');
        $this->isUpdateParentCategoryMode = false;
        $this->pcategory_id = $this->pcategory_name = null;
    }

    public function showCategoryModalForm()
    {
        $this->resetErrorBag();
        $this->dispatch('showCategoryModalForm');
    }

    public function hideCategoryModalForm()
    {
        $this->dispatch('hideCategoryModalForm');
        $this->isUpdateCategoryMode = false;
        $this->category_id = $this->category_name = null;
        $this->parent = 0;
    }

    public function render()
    {
        return view('livewire.admin.categories', [
            'pcategories' => ParentCategory::orderBy('ordering', 'asc')->paginate($this->pcategoriesPerPage, ['*'], 'pcat_page'),
            'categories' => Category::orderBy('ordering', 'asc')->paginate($this->categoriesPerPage, ['*'], 'cat_page')
        ]);
    }
}
