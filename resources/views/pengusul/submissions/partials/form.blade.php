<div class="space-y-4">
    <!-- Name -->
    <div>
        <label for="name" class="block text-sm font-bold text-[#023E8A] mb-1">Nama Kebudayaan <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name" value="{{ old('name', $submission->name ?? '') }}" 
            class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:border-[#0077B6] focus:ring-[#00B4D8] hover:border-[#0096C7] transition-colors"
            required>
        @error('name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Category -->
    <div>
        <label for="category" class="block text-sm font-bold text-[#023E8A] mb-1">Kategori <span class="text-red-500">*</span></label>
        <div class="relative">
            <select name="category" id="category" 
                class="w-full px-4 py-2.5 pr-10 border border-slate-200 rounded-lg focus:border-[#0077B6] focus:ring-2 focus:ring-[#00B4D8]/20 hover:border-[#0096C7] transition-all appearance-none bg-white cursor-pointer font-medium text-slate-700"
                required>
                <option value="" class="text-slate-400">Pilih Kategori</option>
                <option value="Tradisi Lisan" {{ old('category', $submission->category ?? '') == 'Tradisi Lisan' ? 'selected' : '' }}>Tradisi Lisan</option>
                <option value="Seni Pertunjukan" {{ old('category', $submission->category ?? '') == 'Seni Pertunjukan' ? 'selected' : '' }}>Seni Pertunjukan</option>
                <option value="Adat Istiadat" {{ old('category', $submission->category ?? '') == 'Adat Istiadat' ? 'selected' : '' }}>Adat Istiadat</option>
                <option value="Pengetahuan Tradisional" {{ old('category', $submission->category ?? '') == 'Pengetahuan Tradisional' ? 'selected' : '' }}>Pengetahuan Tradisional</option>
                <option value="Keterampilan Tradisional" {{ old('category', $submission->category ?? '') == 'Keterampilan Tradisional' ? 'selected' : '' }}>Keterampilan Tradisional</option>
                <option value="Lainnya" {{ old('category', $submission->category ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
            <!-- Custom Chevron Icon -->
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="w-5 h-5 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>
        @error('category')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Address -->
    <div>
        <label for="address" class="block text-sm font-bold text-[#023E8A] mb-1">Alamat Lokasi <span class="text-red-500">*</span></label>
        <input type="text" name="address" id="address" value="{{ old('address', $submission->address ?? '') }}" 
            class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:border-[#0077B6] focus:ring-[#00B4D8] hover:border-[#0096C7] transition-colors"
            required>
        @error('address')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>


    <!-- Description -->
    <div>
        <label for="description" class="block text-sm font-bold text-[#023E8A] mb-1">Deskripsi (Minimal 50 karakter) <span class="text-red-500">*</span></label>
        <textarea name="description" id="description" rows="6" 
            class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:border-[#0077B6] focus:ring-[#00B4D8] hover:border-[#0096C7] transition-colors"
            required>{{ old('description', $submission->description ?? '') }}</textarea>
        <p class="mt-1 text-xs text-slate-500">Jelaskan secara detail tentang kebudayaan yang diajukan.</p>
        @error('description')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- File Upload -->
    <div class="space-y-3">
        <label class="block text-sm font-bold text-[#023E8A]">Upload Bukti Pendukung</label>
        
        <!-- Dropzone -->
        <div 
            @dragover.prevent="dragover = true"
            @dragleave.prevent="dragover = false"
            @drop.prevent="dragover = false; handleDrop($event)"
            @click="$refs.fileInput.click()"
            :class="dragover ? 'border-[#0077B6] bg-[#0077B6]/5' : 'border-slate-300 hover:border-[#0077B6] hover:bg-slate-50'"
            class="group relative border-2 border-dashed rounded-xl p-8 text-center transition-all duration-300 cursor-pointer"
        >
            <input 
                type="file" 
                name="files[]" 
                id="files" 
                multiple 
                class="hidden" 
                x-ref="fileInput"
                @change="handleFileSelect"
                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp,.mp4,.avi,.mov"
            >
            
            <div class="space-y-4 pointer-events-none">
                <div class="mx-auto w-16 h-16 rounded-full bg-slate-100 group-hover:scale-110 group-hover:bg-[#0077B6]/10 flex items-center justify-center text-slate-400 group-hover:text-[#0077B6] transition-all duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-base font-semibold text-slate-700">
                        <span class="text-[#0077B6] group-hover:underline">Klik untuk upload</span> atau drag & drop
                    </p>
                    <p class="text-xs text-slate-500 mt-1">
                        PDF, DOCX, JPG, MP4 (Max 5 file)
                    </p>
                </div>
            </div>
        </div>

        @error('files')
            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
        @enderror
        @if($errors->has('files.*'))
            @foreach($errors->get('files.*') as $error)
                <p class="mt-1 text-xs text-red-600 font-medium">{{ $error[0] }}</p>
            @endforeach
        @endif

        <!-- File Previews (New Uploads) -->
        <template x-if="files.length > 0">
            <div class="mt-6 space-y-3">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                    <span>File Terpilih</span>
                    <span class="px-2 py-0.5 rounded-full bg-[#0077B6] text-white text-[10px]" x-text="files.length"></span>
                </h4>
                <div class="grid gap-3">
                    <template x-for="(file, index) in files" :key="index">
                        <div class="flex items-center justify-between p-3 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 group">
                            <div class="flex items-center gap-4 overflow-hidden">
                                <!-- Type Icon -->
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-slate-50 shrink-0">
                                    <template x-if="file.type.startsWith('image/')">
                                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </template>
                                    <template x-if="file.type.startsWith('video/')">
                                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10z"></path></svg>
                                    </template>
                                    <template x-if="!file.type.startsWith('image/') && !file.type.startsWith('video/')">
                                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </template>
                                </div>
                                
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-700 truncate" x-text="file.name"></p>
                                    <p class="text-xs text-slate-500" x-text="formatSize(file.size)"></p>
                                </div>
                            </div>
                            
                            <!-- Remove Button -->
                            <button type="button" 
                                @click="removeFile(index)"
                                class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all duration-200"
                                title="Batalkan Upload">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>

        <!-- Existing Files List (Only for Edit) -->
        @if(isset($submission) && $submission->files->count() > 0)
            <div class="mt-6 space-y-3">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                    <span>File Terupload</span>
                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px]">{{ $submission->files->count() }}</span>
                </h4>
                <div class="grid gap-3">
                    @foreach($submission->files as $file)
                        <div class="flex items-center justify-between p-3 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 group">
                            <div class="flex items-center gap-4 overflow-hidden">
                                <!-- Icon -->
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-slate-50 shrink-0">
                                    @if($file->file_icon == 'image')
                                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    @elseif($file->file_icon == 'video')
                                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10z"></path></svg>
                                    @elseif($file->file_icon == 'document')
                                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    @else
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-700 truncate group-hover:text-[#0077B6] transition-colors" title="{{ $file->original_name }}">
                                        {{ $file->original_name }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        {{ $file->file_size_human }} • {{ strtoupper($file->file_type) }}
                                    </p>
                                </div>
                            </div>
                            
                            <button type="button" 
                                onclick="if(confirm('Hapus file ini?')) { document.getElementById('delete-file-{{ $file->id }}').submit(); }"
                                class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all duration-200"
                                title="Hapus File">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Hidden Forms for File Deletion -->
    @if(isset($submission) && $submission->files->count() > 0)
        @foreach($submission->files as $file)
            <form id="delete-file-{{ $file->id }}" action="{{ route('pengusul.submissions.files.destroy', [$submission, $file]) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @endif
</div>

<script>
    // Simple script to show selected filenames (optional UX improvement)
    document.getElementById('files').addEventListener('change', function(e) {
        const fileList = Array.from(e.target.files).map(file => file.name).join(', ');
        if (fileList) {
            alert('File terpilih: \n' + fileList);
        }
    });
</script>
