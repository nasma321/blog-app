@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-3">
                <h2>{{ __('Blogs') }}</h2>
                <button type="button" id="addNewBlog" class="btn btn-primary btn-sm">New Blog</button>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <?php foreach ($blogs as $blog): ?>
                <p style="display:none;"><?php echo $blog['id']; ?></p>
                <div class="card">
                    <div class="card-header">
                        <?php echo $blog['title']; ?>
                    </div>
                    <div class="card-body">
                        <?php
                            $content = strip_tags($blog['content']); // Remove HTML tags
                            $limit = 100; // Character limit

                            if (strlen($content) > $limit) {
                                echo substr($content, 0, $limit) . '...';
                            } else {
                                echo $content;
                            }
                        ?>
                    </div>

                    <div class="card-footer">
                        <button type="button" id="view" class="btn btn-primary btn-sm" data-id="<?php echo $blog['id']; ?>">View</button>
                        <button type="button" id="edit" class="btn btn-warning btn-sm" data-id="<?php echo $blog['id']; ?>">Edit</button>
                        <button type="button" id="delete" class="btn btn-danger btn-sm" data-id="<?php echo $blog['id']; ?>">Delete</button>
                    </div>
                </div><br><br>
            <?php endforeach; ?> 
        </div>
    </div>
</div>


<!-- boostrap model -->
<div class="modal fade" id="blogModel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="blogModelTitle">Add Blog</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>            
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="editBlog" name="editBlog" class="form-horizontal" method="POST">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" rows="100" cols="80" required></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="saveBlog">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- end bootstrap model -->


<style>
    .float-end {
        float: right;
    }

</style>

<script type="text/javascript">
    $(document).ready(function($){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#content').summernote({
            height: 450,
        });

        $('#addNewBlog').click(function () {
            $('#editBlog').trigger("reset");
            $('#content').summernote('code', '');
            $('#blogModel').modal('show');
            $('#blogModelTitle').html("Add Blog");
        });


        $('body').on('click', '#saveBlog', function (event) {
            event.preventDefault();

            var id = $("#id").val();
            var title = $("#title").val();
            var content = $("#content").val();

            // Check if the title and content fields are not empty
            if (title.trim() === "" || content.trim() === "") {
                alert("Title and Content are required fields.");
            } else {
                $("#saveBlog").html('Please Wait...');
                $("#saveBlog").attr("disabled", true);

                $.ajax({
                    type: "POST",
                    url: "{{ url('blogs') }}",
                    data: {
                        id: id,
                        title: title,
                        content: content,
                    },
                    dataType: 'json',
                    success: function (res) {
                        window.location.reload();
                        $("#saveBlog").html('Save');
                        $("#saveBlog").attr("disabled", false);
                    }
                });
            }
        });

        $('body').on('click', '#view', function(event){
            var id = $(this).data('id');
            var url = "{{ route('blogs.show', ':id') }}".replace(':id', id);
    
            window.open(url+'?view=1', '_blank');
        });

        $('body').on('click', '#edit', function () {
            var id = $(this).data('id'); 

            $.ajax({
                type:"GET",
                url: "{{ route('blogs.show', ':id') }}".replace(':id', id),
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    $('#blogModelTitle').html("Edit Blog");
                    $('#blogModel').modal('show');
                    $('#id').val(res.id);
                    $('#title').val(res.title);
                    $('#content').summernote('code', res.content);
                }
            });
        });

        $('body').on('click', '#delete', function () {
            if (confirm("Delete Record?") == true) {
                var id = $(this).data('id'); 
                $.ajax({
                    type:"DELETE",
                    url: "{{ route('blogs.show', ':id') }}".replace(':id', id),
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>
@endsection
