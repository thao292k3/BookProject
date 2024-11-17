@extends('admin.master')

@section('body')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js"></script>

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="container">
    <div class="row-5">
        <div class="col-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">Sửa bài viết</h4>
                        <p class="mb-30">Vui lòng điền thông tin chi tiết bên dưới</p>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('blog.update', $blog->blog_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Tiêu đề bài viết -->
                    <div class="form-group">
                        <label for="title">Tiêu đề bài viết</label>
                        <input class="form-control" type="text" name="title" id="title" placeholder="Nhập tiêu đề" value="{{ old('title', $blog->title ?? '') }}">
                        @error('title')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Nội dung -->
                    <div class="form-group">
                        <label for="content">Nội dung</label>
                        <textarea class="form-control" name="content" id="content" rows="6" placeholder="Nhập nội dung bài viết">{{ old('content', $blog->content ?? '') }}</textarea>
                        @error('content')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Hình ảnh bài viết -->
                    <div class="form-group">
                        <label for="image_path">Hình ảnh bài viết</label>
                        <input type="file" name="image_path" id="image_path" class="form-control-file">
                        @if(isset($blog) && $blog->image_path)
                        <img src="{{ asset('storage/' . $blog->image_path) }}" alt="Current Image" class="mt-2" width="150">
                        @endif
                    </div>

                    <!-- Tên người dùng -->
                    <div class="form-group">
                        <label for="user_id">Người dùng</label>
                        <input class="form-control" type="text" value="{{ $blog->user->name ?? 'Không xác định' }}" disabled>
                    </div>


                    <!-- Ngày đăng -->
                    <div class="form-group">
                        <label for="date">Ngày đăng</label>
                        <input class="form-control" name="date" id="date" type="datetime-local" value="{{ old('date', \Carbon\Carbon::parse($blog->date)->format('Y-m-d\TH:i') ?? '') }}">
                    </div>

                    <!-- Trạng thái -->
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select class="form-control" name="status" id="status">
                            <option value="pending" {{ old('status', $blog->status ?? '') == 'pending' ? 'selected' : '' }}>Đang chờ</option>
                            <option value="approved" {{ old('status', $blog->status ?? '') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                        </select>
                    </div>

                    <!-- Danh mục -->
                    <div class="form-group">
                        <label for="category_id">Danh mục</label>
                        <select class="form-control" name="category_id" id="category_id">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Lượt thích -->
                    <div class="form-group">
                        <label for="likes">Lượt thích</label>
                        <input class="form-control" name="likes" id="likes" type="number" value="{{ old('likes', $blog->likes ?? 0) }}">
                    </div>

                    <!-- Nút Lưu -->
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Lưu bài viết</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    ClassicEditor
        .create(document.querySelector('#content'))
        .then(editor => {
            console.log('Editor was initialized', editor);
        })
        .catch(error => {
            console.error('There was a problem', error);
        });
</script>
@endsection