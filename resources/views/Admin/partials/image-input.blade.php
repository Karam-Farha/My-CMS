<div class="my-3">
    {{-- attached_file --}}
    @isset($attachedFileFlag)
        <div class="form-group">
            <label class="mb-2" for="attached_file"><span>الملفات المرفقة</span></label>
            <div class="needsclick dropzone {{ $errors->has('attached_file') ? 'is-invalid' : '' }}" id="attached_file-dropzone">
            </div>
            @if($errors->has('attached_file'))
                <div class="invalid-feedback">
                    {{ $errors->first('attached_file') }}
                </div>
            @endif
        </div>
    @endisset
    
    {{-- main_photo --}}
    @isset($mainPhotoFlag)
        <div class="form-group">
            <label class="mb-2" for="main_photo"><span>الصورة الرئيسية</span></label>
            <div class="needsclick dropzone {{ $errors->has('main_photo') ? 'is-invalid' : '' }}" id="main_photo-dropzone">
            </div>
            @if($errors->has('main_photo'))
                <div class="invalid-feedback">
                    {{ $errors->first('main_photo') }}
                </div>
            @endif
        </div>
    @endisset
    
    {{-- garllery --}}
    @isset($galleryFlag)
        <div class="form-group">
            <label class="mb-2" for="garllery"><span>معرض الصور</span></label>
            <div class="needsclick dropzone {{ $errors->has('garllery') ? 'is-invalid' : '' }}" id="garllery-dropzone">
            </div>
            @if($errors->has('garllery'))
                <div class="invalid-feedback">
                    {{ $errors->first('garllery') }}
                </div>
            @endif
        </div>
    @endisset

</div>

@section('scripts')
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function () {
            var minFiles = 1; // minimum file must be to upload
            var maxFiles = 1; // maximum file allows to upload
            fileNewName = '';
            $("#garllery-dropzone").dropzone({
                url: '{{ route('storeMedia') }}',
                maxFilesize: 4, // MB
                acceptedFiles: '.jpeg,.jpg,.png,.gif',
                addRemoveLinks: true,
                headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                params: {
                size: 4,
                width: 4096,
                height: 4096
                },
                success: function (file, response) {
                $('form').append('<input type="hidden" name="garllery[]" value="' + response.name + '">')
                uploadedGarlleryMap[file.name] = response.name
                },
                removedfile: function (file) {
                console.log(file)
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedGarlleryMap[file.name]
                }
                $('form').find('input[name="garllery[]"][value="' + name + '"]').remove()
                },
                init: function () {
                @if(isset($product) && $product->garllery)
                var files = {!! json_encode($product->garllery) !!}
                    for (var i in files) {
                    var file = files[i]
                    console.log(file)
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="garllery[]" value="' + file.file_name + '">')
                    }
                @endif
                },
                error: function (file, response) {
                    if ($.type(response) === 'string') {
                        var message = response //dropzone sends it's own error messages in string
                    } else {
                        var message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
                }
            });

            $("#attached_file-dropzone").dropzone({
                url: '{{ route('storeMedia') }}',
                maxFilesize: 20, // MB
                maxFiles: 1,
                addRemoveLinks: true,
                headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                params: {
                size: 20
                },
                success: function (file, response) {
                $('form').find('input[name="attached_file"]').remove()
                $('form').append('<input type="hidden" name="attached_file" value="' + response.name + '">')
                },
                removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="attached_file"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
                },
                init: function () {
                @if(isset($product) && $product->attached_file)
                var file = {!! json_encode($product->attached_file) !!}
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview_url)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="attached_file" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
                },
                error: function (file, response) {
                    if ($.type(response) === 'string') {
                        var message = response //dropzone sends it's own error messages in string
                    } else {
                        var message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
                }
            });

            let uploadedMainPhotoMap = {}
            $("#main_photo-dropzone").dropzone({
                minFiles: minFiles,
                maxFiles: maxFiles,
                url: '{{ route('storeMedia') }}',
                maxFilesize: 5, // MB
                timeout: 5000,
                acceptedFiles: '.jpeg,.jpg,.png,.gif',
                addRemoveLinks: true,
                headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                params: {
                size: 4,
                width: 4096,
                height: 4096
                },
                success: function (file, response) {
                fileNewName = response.name
                $('form').append('<input type="hidden" name="main_photo[]" value="' + response.name + '">')
                uploadedMainPhotoMap[file.name] = response.name
                },

                removedfile: function(file) {
                    var filename = ''
                    if (file.hasOwnProperty('upload')) {
                        filename = file.upload.filename;
                    } else {
                        filename = file.name;
                    }
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ route('deleteMedia') }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: {
                            filename: fileNewName,
                        },
                        sucess: function(data) {
                            console.log('removed success: ' + data);
                        }
                    });

                    // remove file name from uploadedMainPhotoMap object
                    Reflect.deleteProperty(uploadedMainPhotoMap, file.name);

                    file.previewElement.remove();

                    $('form').find('input[name="main_photo[]"][value="' + filename + '"]').remove()

                },
                maxfilesexceeded: function(file) {
                    alert("Maximum " + maxFiles + " files are allowed to upload...!");
                    this.removeAllFiles();
                    this.addFile(file);
                    myDropZone.removeFile(file);
                },
                init: function () {
                    @if(isset($product) && $product->mainPhotoArray)
                    var files = {!! json_encode($product->mainPhotoArray) !!}
                    console.log(files)
                        for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        this.options.thumbnail.call(this, file, file.preview_url)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="main_photo[]" value="' + file.file_name + '">')
                        }
                    @endif

                    // minimum files limit upload validation starts
                    var submitButton = document.querySelector("#submit-all");
                    myDropzone = this;
                    submitButton.addEventListener("click", function(e) {
                        e.preventDefault();
                        var imagelength = Object.keys(uploadedMainPhotoMap).length;
                        console.log(imagelength)
                        if (imagelength < minFiles) {
                            console.log('we here 1')
                            alert("Minimum " + minFiles + " file needs to upload...!");
                            return false;
                        } else {
                            console.log('we here 2')
                            document.getElementById('dropZone-form').submit();
                        }
                        /*Dropzone.forElement(".dropzone").options.autoProcessQueue = false;
                        if (myDropzone.getQueuedFiles().length >= minFiles) {
                            //myDropzone.processQueue();
                            Dropzone.forElement(".dropzone").options.autoProcessQueue = true;                        
                            Dropzone.forElement(".dropzone").processQueue();
                            $('#form-create').submit();
                        } else { // Minimum file upload validations
                            Dropzone.forElement(".dropzone").options.autoProcessQueue = false;
                            alert("Minimum "+minFiles+" file needs to upload...!");
                            return false;
                        }*/
                    });
                    // minimum files limit upload validation ends
                },
                error: function (file, response) {
                    if ($.type(response) === 'string') {
                        var message = response //dropzone sends it's own error messages in string
                    } else {
                        var message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
                }
            });

        });
    </script>
@endsection