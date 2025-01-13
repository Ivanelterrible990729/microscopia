<div
    x-data="{
        isDragging: false,
        previews: [],
        errors: [],
        loading: false,
        handleFiles(files) {
            const maxFileSize = 10 * 1024 * 1024; // Tamaño máximo: 10 MB
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            const resizeImage = (file, maxWidth = 200, maxHeight = 200) => {
                return new Promise((resolve) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = new Image();
                        img.onload = () => {
                            const canvas = document.createElement('canvas');
                            const ctx = canvas.getContext('2d');

                            let width = img.width;
                            let height = img.height;

                            // Redimensionar manteniendo la proporción
                            if (width > height) {
                                if (width > maxWidth) {
                                    height *= maxWidth / width;
                                    width = maxWidth;
                                }
                            } else {
                                if (height > maxHeight) {
                                    width *= maxHeight / height;
                                    height = maxHeight;
                                }
                            }

                            canvas.width = width;
                            canvas.height = height;

                            ctx.drawImage(img, 0, 0, width, height);

                            resolve(canvas.toDataURL('image/jpeg', 0.8));
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });
            };

            for (let file of files) {
                if (!allowedTypes.includes(file.type)) {
                    this.errors.push(`El archivo '${file.name}'' no es un tipo de imagen válido.`);
                    continue;
                }

                if (file.size > maxFileSize) {
                    this.errors.push(`El archivo '${file.name}' supera el tamaño máximo de 10 MB.`);
                    continue;
                }

                resizeImage(file).then((resizedImage) => {
                    this.previews.push(resizedImage);
                });
            }
        },
        removePreview(index) {
            this.previews.splice(index, 1);
        },
        clearErrors() {
            this.errors = [];
        }
    }"
>
    <x-base.dialog.title>
        <h2 class="mr-auto flex flex-1 items-center text-base font-medium">
            <x-base.lucide
                icon="plus"
                class="mr-2"
            />
            {{ __('Upload images') }}
        </h2>
    </x-base.dialog.title>

    <form wire:submit="uploadFiles">
        <x-base.dialog.description>
            <x-validation-errors class="mb-5">
                <template x-for="(error, index) in errors" :key="index">
                    <li x-text="error"></li>
                </template>
            </x-validation-errors>

            <!-- Begin: Área de drop -->
            <div
                class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center"
                :class="{ 'border-blue-500 bg-blue-50': isDragging }"
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="
                    isDragging = false;
                    clearErrors();
                    handleFiles($event.dataTransfer.files);
                "
            >
                <p class="text-gray-500 mb-2">Arrastra y suelta tus imágenes aquí</p>
                <p class="text-gray-400 text-sm">O selecciona imágenes desde tu computadora</p>

                <!-- Input de archivos -->
                <input
                    type="file"
                    multiple
                    wire:model="files"
                    x-ref="fileInput"
                    @change="
                        clearErrors();
                        handleFiles($refs.fileInput.files);
                    "
                    class="hidden"
                >
                <button
                    type="button"
                    @click="$refs.fileInput.click()"
                    class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:ring focus:ring-blue-300"
                >
                    Seleccionar imágenes
                </button>
            </div>
            <!-- End: Área de drop -->

            <!-- Begin: Previews optimizadas -->
            <div class="mt-4 grid grid-cols-3 gap-4 max-h-80 overflow-y-auto">
                <template x-for="(preview, index) in previews" :key="index">
                    <div class="col-span-3 lg:col-span-1 relative">
                        <div class="w-full h-48 image-fit rounded">
                            <img :src="preview" alt="Preview">
                        </div>
                        <button
                            type="button"
                            @click="removePreview(index)"
                            class="absolute top-1 right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"
                        >
                            &times;
                        </button>
                    </div>
                </template>
            </div>
            <!-- End: Previews optimizadas -->
        </x-base.dialog.description>

        <x-base.dialog.footer>
            <x-base.button
                class="mr-2"
                data-tw-dismiss="modal"
                type="button"
                variant="secondary"
            >
            <x-base.lucide
                icon="undo-2"
                class="mr-2"
            />
                {{ __('Cancel') }}
            </x-base.button>
            <x-base.button
                type="submit"
                variant="success"
                x-bind:disabled="loading || previews.length === 0"
            >
                <x-base.lucide
                    icon="upload"
                    class="mr-2"
                />
                {{ __('Upload images') }}
            </x-base.button>
        </x-base.dialog.footer>
    </form>
</div>
