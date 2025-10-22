<div>
    <div class="row">
        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="h4 text-blue">Thể loại cha</h4>
                    </div>
                    <div class="pull-right">
                        <a href="javascript:;" wire:click="addParentCategory" class="btn btn-primary">Thêm thể loại cha</a>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-stripped table-sm">
                        <thead class="bg-secondary text-white">
                            <th>#</th>
                            <th>Tên</th>
                            <th>Số lượng thể loại con</th>
                            <th>Hành động</th>
                        </thead>
                        <tbody id="sortable_parent_categories">
                            @forelse ($pcategories as $item)
                                <tr data-index="{{ $item->id }}" data-ordering="{{ $item->ordering }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->children->count() }}</td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="javascript:;" wire:click="editParentCategory({{ $item->id }})"
                                                class="text-primary mx-2">
                                                <i class="dw dw-edit2"></i>
                                            </a>
                                            <a href="javascript:;"
                                                wire:click="deleteParentCategory({{ $item->id }})"
                                                class="text-danger mx-2">
                                                <i class="dw dw-delete-3"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="4">
                                        <span class="text-danger">Không tìm thấy thể loại nào!</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-block mt-1 text-center">
                    {{ $pcategories->links('livewire::simple-bootstrap') }}
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="h4 text-blue">Thể loại</h4>
                    </div>
                    <div class="pull-right">
                        <a href="javascript:;" wire:click="addCategory()" class="btn btn-primary">Thêm thể loại</a>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-stripped table-sm">
                        <thead class="bg-secondary text-white">
                            <th>#</th>
                            <th>Tên</th>
                            <th>Thể loại cha</th>
                            <th>Số lượng bài viết</th>
                            <th>Hành động</th>
                        </thead>
                        <tbody id="sortable_categories">
                            @forelse ($categories as $item)
                                <tr data-index="{{ $item->id }}" data-ordering="{{ $item->ordering }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ !is_null($item->parent_category) ? $item->parent_category->name : ' - ' }}
                                    </td>
                                    <td>{{ $item->posts->count() }}</td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="javascript:;" wire:click="editCategory({{ $item->id }})"
                                                class="text-primary mx-2">
                                                <i class="dw dw-edit2"></i>
                                            </a>
                                            <a href="javascript:;" wire:click="deleteCategory({{ $item->id }})"
                                                class="text-danger mx-2">
                                                <i class="dw dw-delete-3"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <span class="text-danger">Không tìm thấy thể loại nào!</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-block mt-1 text-center">
                    {{ $categories->links('livewire::simple-bootstrap') }}
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="pcategory_modal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content"
                wire:submit="{{ $isUpdateParentCategoryMode ? 'updateParentCategory()' : 'createParentCategory()' }}">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ $isUpdateParentCategoryMode ? 'Cập nhật thể loại cha' : 'Thêmthể loại cha' }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    @if ($isUpdateParentCategoryMode)
                        <input type="hidden" wire:model="pcategory_id">
                    @endif

                    <div class="form-group">
                        <label for=""><b>Tên thể loại cha</b></label>
                        <input type="text" class="form-control" wire:model="pcategory_name"
                            placeholder="Điền tên thể loại cha">
                        @error('pcategory_name')
                            <span class="text-danger ml-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Đóng
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{ $isUpdateParentCategoryMode ? 'Lưu thay đổi' : 'Tạo mới' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="category_modal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content"
                wire:submit="{{ $isUpdateCategoryMode ? 'updateCategory()' : 'createCategory()' }}">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ $isUpdateCategoryMode ? 'Cập nhật thể loại' : 'Thêm thể loại' }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    @if ($isUpdateCategoryMode)
                        <input type="hidden" wire:model="category_id">
                    @endif
                    <div class="form-group">
                        <label for=""><b>Thể loại cha</b>:</label>
                        <select wire:model="parent" class="custom-select" name="" id="">
                            <option value="0">Không phân loại</option>
                            @foreach ($pcategories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('parent')
                            <span class="text-danger ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for=""><b>Tên thể loại</b></label>
                        <input type="text" class="form-control" wire:model="category_name"
                            placeholder="Điền tên thể loại">
                        @error('category_name')
                            <span class="text-danger ml-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Đóng
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{ $isUpdateCategoryMode ? 'Lưu thay đổi' : 'Tạo mới' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
