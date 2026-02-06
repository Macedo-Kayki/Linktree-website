<x-app-layout>

    <div class="max-w-[1400px] mx-auto flex flex-row w-full gap-6 p-6">

        <div class="w-full lg:w-2/3 space-y-6">
            
            <div class="bg-indigo-700 shadow-lg rounded-2xl p-8 text-white">
                <h2 class="text-2xl font-bold">Editor de Links</h2>
                <p class="text-indigo-100 text-sm opacity-80">Adicione ícones para destacar seus links.</p>
                @if($linktree && $linktree->exists())
                    <button type="button" onclick="copyLink()" class="bg-white text-indigo-700 px-4 py-2 rounded-lg font-bold text-sm shadow-md hover:bg-gray-100 transition" data-user-id="{{ auth()->user()->id }}">
                        🔗 Copiar Meu Link
                    </button>
                @else
                    <p class="text-indigo-200 text-sm">Salve seu linktree para gerar um link compartilhável.</p>
                @endif
            </div>
            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
                <form action="{{ route('editor.store') }}" method="post" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Seu Nome/Usuário</label>
                        <input type="text" id="input-name" name="input_name" placeholder="Ex: @seuusuario" maxlength="20" 
                            value="{{ $linktree?->title ?? '' }}"
                            class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 text-gray-800 dark:text-white transition">
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Cor do Background</label>
                            <div class="flex items-center gap-3">
                                <input type="color" id="bg-color" name="bg_color" value="{{ $linktree?->bg_color ?? '#1f2937' }}"
                                    class="w-16 h-12 rounded-lg cursor-pointer border-none">
                                <span id="bg-color-label" class="text-sm text-gray-600 dark:text-gray-400 break-all">{{ $linktree?->bg_color ?? '#1f2937' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Cor dos Textos</label>
                            <div class="flex items-center gap-3">
                                <input type="color" id="text-color" name="text_color" value="{{ $linktree?->text_color ?? '#ffffff' }}"
                                    class="w-16 h-12 rounded-lg cursor-pointer border-none">
                                <span id="text-color-label" class="text-sm text-gray-600 dark:text-gray-400 break-all">{{ $linktree?->text_color ?? '#ffffff' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Imagem de Fundo</label>
                            <div class="flex items-center gap-3">
                                <label class="cursor-pointer flex items-center justify-center w-16 h-12 bg-gray-50 dark:bg-gray-900 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-indigo-500 transition flex-shrink-0">
                                    @if($linktree?->bg_image)
                                        <img id="bg-preview-img" src="{{ asset('storage/' . $linktree->bg_image) }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    @endif
                                    <input type="file" name="bg_image" id="bg-image-input" class="hidden" accept="image/*">
                                </label>
                                <span class="text-xs text-gray-500">{{ $linktree?->bg_image ? 'Mudar' : 'Adicionar' }}</span>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 dark:border-gray-700">

                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Configurar Links</label>
                            <button type="button" id="add-link-btn" class="text-indigo-500 text-sm font-bold hover:text-indigo-400 transition">
                                + Adicionar Novo Link
                            </button>
                        </div>

                        <div id="links-container" class="space-y-4">
                            @if($linktree && $linktree->dados->isNotEmpty())
                                @foreach($linktree->dados as $index => $dado)
                                    <div class="link-card p-6 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700 space-y-4" data-index="{{ $index }}" data-original-icon="{{ $dado->icon }}">
                                        <div class="flex-1 space-y-2">
                                            <input type="text" name="links[{{ $index }}][name_link]" value="{{ $dado->name_link }}" 
                                                   class="link-title-input w-full font-bold bg-transparent border-none p-0 focus:ring-0 text-gray-800 dark:text-white" placeholder="Título do Link">
                                            
                                            <input type="text" name="links[{{ $index }}][url_link]" value="{{ $dado->url_link }}"
                                                   class="w-full text-sm text-gray-400 bg-transparent border-none p-0 focus:ring-0" placeholder="URL de destino">
                                        </div>

                                        <div class="flex items-center gap-3 mt-3">
                                            <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Cor:</label>
                                            <input type="color" name="links[{{ $index }}][button_color]" value="{{ $dado->button_color ?? '#ffffff' }}"
                                                   class="w-10 h-8 rounded-lg cursor-pointer border-none link-color-input">
                                            <span class="text-xs text-gray-500 link-color-label">{{ $dado->button_color ?? '#ffffff' }}</span>
                                        </div>

                                        <div class="flex items-center gap-3 mt-4">
                                            <div class="flex-shrink-0">
                                                <label class="cursor-pointer flex items-center justify-center w-10 h-10 bg-white dark:bg-gray-800 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-indigo-500 transition">
                                                    @if($dado->icon)
                                                        <img class="img-preview-thumb w-full h-full object-cover rounded-lg" src="{{ asset('storage/' . $dado->icon) }}">
                                                        <svg class="img-icon-placeholder hidden w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    @else
                                                        <img class="img-preview-thumb hidden w-full h-full object-cover rounded-lg" src="#">
                                                        <svg class="img-icon-placeholder w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    @endif
                                                    <input type="file" name="links[{{ $index }}][icon]" class="link-image-input hidden" accept="image/*">
                                                </label>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $dado->icon ? 'Alterar' : 'Adicionar' }} ícone</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="link-card p-6 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700 space-y-4" data-index="0">
                                    <div class="flex-1 space-y-2">
                                        <input type="text" name="links[0][name_link]" placeholder="Título do Link" 
                                               class="link-title-input w-full font-bold bg-transparent border-none p-0 focus:ring-0 text-gray-800 dark:text-white">
                                        
                                        <input type="text" name="links[0][url_link]" placeholder="URL de destino"
                                               class="w-full text-sm text-gray-400 bg-transparent border-none p-0 focus:ring-0">
                                    </div>

                                    <div class="flex items-center gap-3 mt-3">
                                        <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Cor:</label>
                                        <input type="color" name="links[0][button_color]" value="#ffffff"
                                               class="w-10 h-8 rounded-lg cursor-pointer border-none link-color-input">
                                        <span class="text-xs text-gray-500 link-color-label">#ffffff</span>
                                    </div>

                                    <div class="flex items-center gap-3 mt-4">
                                        <div class="flex-shrink-0">
                                            <label class="cursor-pointer flex items-center justify-center w-10 h-10 bg-white dark:bg-gray-800 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-indigo-500 transition">
                                                <svg class="img-icon-placeholder w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <img class="img-preview-thumb hidden w-full h-full object-cover rounded-lg" src="#">
                                                <input type="file" name="links[0][icon]" class="link-image-input hidden" accept="image/*">
                                            </label>
                                        </div>
                                        <span class="text-xs text-gray-500">Adicionar ícone</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg transition-all">
                        Salvar Alterações
                    </button>
                </form>
            </div>
        </div>

        <div class="hidden lg:block lg:w-1/3">
            <div class="sticky top-6">
                <div class="relative w-[320px] mx-auto h-[640px] bg-white dark:bg-black rounded-[3.5rem] shadow-2xl border-[10px] border-gray-900 dark:border-gray-950 overflow-hidden">
                    <div class="absolute top-0 w-full h-8 bg-gray-900 dark:bg-gray-950 flex justify-center items-end pb-1">
                        <div class="w-24 h-4 bg-black rounded-full"></div>
                    </div>
                    
                    <div id="preview-content" class="p-6 pt-16 flex flex-col items-center h-full" style="background-color: {{ $linktree?->bg_color ?? '#1f2937' }}; color: {{ $linktree?->text_color ?? '#ffffff' }}; @if($linktree?->bg_image) background-image: url('{{ asset('storage/' . $linktree->bg_image) }}'); background-size: cover; background-position: center; @endif">
                        <div class="absolute inset-0 rounded-[3.5rem] @if($linktree?->bg_image) bg-black/30 @endif"></div>
                        
                        <div class="relative z-10 w-20 h-20 bg-gradient-to-tr from-indigo-600 to-purple-500 rounded-full mb-4 flex items-center justify-center shadow-xl">
                            <span class="text-white font-bold text-2xl">{{ auth()->user()->initials }}</span>
                        </div>
                        
                        <h3 id="preview-name" class="relative z-10 font-bold text-lg" style="color: {{ $linktree?->text_color ?? '#ffffff' }};">@seuusuario</h3>
                        <p class="relative z-10 text-xs mb-8" style="color: {{ $linktree?->text_color ?? '#ffffff' }}; opacity: 0.8;">Bio do perfil</p>

                        <div id="preview-links-list" class="relative z-10 w-full space-y-3">
                            </div>

                        <div class="relative z-10 mt-auto pb-6 text-[10px] font-black tracking-widest uppercase" style="color: {{ $linktree?->text_color ?? '#ffffff' }}; opacity: 0.5;">LinkNext</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const inputName = document.getElementById('input-name');
        const previewName = document.getElementById('preview-name');
        const addLinkBtn = document.getElementById('add-link-btn');
        const linksContainer = document.getElementById('links-container');
        const previewLinksList = document.getElementById('preview-links-list');
        const bgColorInput = document.getElementById('bg-color');
        const bgColorLabel = document.getElementById('bg-color-label');
        const textColorInput = document.getElementById('text-color');
        const textColorLabel = document.getElementById('text-color-label');
        const bgImageInput = document.getElementById('bg-image-input');
        const bgPreviewImg = document.getElementById('bg-preview-img');
        const previewContent = document.getElementById('preview-content');
        
        previewName.innerText = inputName.value || '@seuusuario';

        inputName.addEventListener('input', (e) => {
            previewName.innerText = e.target.value || '@seuusuario';
        });

        bgColorInput.addEventListener('change', (e) => {
            bgColorLabel.innerText = e.target.value;
            previewContent.style.backgroundColor = e.target.value;
        });

        bgColorInput.addEventListener('input', (e) => {
            previewContent.style.backgroundColor = e.target.value;
        });

        textColorInput.addEventListener('change', (e) => {
            textColorLabel.innerText = e.target.value;
            previewContent.style.color = e.target.value;
            updatePreview();
        });

        textColorInput.addEventListener('input', (e) => {
            previewContent.style.color = e.target.value;
        });

        bgImageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewContent.style.backgroundImage = `url('${event.target.result}')`;
                    previewContent.style.backgroundSize = 'cover';
                    previewContent.style.backgroundPosition = 'center';
                    
                    const overlay = previewContent.querySelector('.absolute');
                    if (overlay) {
                        overlay.classList.add('bg-black/30');
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        function updatePreview() {
            previewLinksList.innerHTML = '';
            const cards = document.querySelectorAll('.link-card');

            cards.forEach((card, index) => {
                const title = card.querySelector('.link-title-input').value || 'Título do Link';
                const imgSrc = card.querySelector('.img-preview-thumb').src;
                const isImgHidden = card.querySelector('.img-preview-thumb').classList.contains('hidden');
                const buttonColor = card.querySelector('.link-color-input')?.value || '#ffffff';
                
                // Calculate text color based on button color
                const textColor = isLightColor(buttonColor) ? '#000000' : '#ffffff';

                const linkHtml = `
                    <div class="relative flex items-center justify-center w-full min-h-[52px] px-12 rounded-2xl font-semibold text-sm shadow-md overflow-hidden transition-all" style="background-color: ${buttonColor}; color: ${textColor};">
                        
                        <div class="${isImgHidden ? 'hidden' : ''} absolute left-2 w-8 h-8 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                            <img src="${imgSrc}" class="w-full h-full object-cover">
                        </div>
                        
                        <span class="w-full text-center leading-tight break-words">${title}</span>
                    </div>
                `;
                previewLinksList.insertAdjacentHTML('beforeend', linkHtml);
            });
        }

        // Function to determine if color is light or dark
        function isLightColor(color) {
            const hex = color.replace('#', '');
            const r = parseInt(hex.substr(0, 2), 16);
            const g = parseInt(hex.substr(2, 2), 16);
            const b = parseInt(hex.substr(4, 2), 16);
            const brightness = (r * 299 + g * 587 + b * 114) / 1000;
            return brightness > 128;
        }

        linksContainer.addEventListener('input', (e) => {
            if (e.target.classList.contains('link-title-input')) {
                updatePreview();
            }
        });

        linksContainer.addEventListener('change', (e) => {
            if (e.target.classList.contains('link-image-input')) {
                const file = e.target.files[0];
                const card = e.target.closest('.link-card');
                const thumb = card.querySelector('.img-preview-thumb');
                const placeholder = card.querySelector('.img-icon-placeholder');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        thumb.src = event.target.result;
                        thumb.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                        updatePreview();
                    }
                    reader.readAsDataURL(file);
                }
            } else if (e.target.classList.contains('link-color-input')) {
                const card = e.target.closest('.link-card');
                const label = card.querySelector('.link-color-label');
                label.innerText = e.target.value;
                updatePreview();
            }
        });

        addLinkBtn.addEventListener('click', () => {
            const cards = document.querySelectorAll('.link-card');
            const newIndex = cards.length;
            const firstCard = cards[0];
            const newCard = firstCard.cloneNode(true);

            newCard.setAttribute('data-index', newIndex);
            newCard.removeAttribute('data-original-icon');

            newCard.querySelectorAll('input').forEach(input => {
                const currentName = input.getAttribute('name');
                if (currentName) {
                    const newName = currentName.replace(/links\[\d+\]/, `links[${newIndex}]`);
                    input.setAttribute('name', newName);
                    if (input.type !== 'color') {
                        input.value = '';
                    } else {
                        input.value = '#ffffff';
                    }
                }
            });

            // Reset color label
            newCard.querySelector('.link-color-label').innerText = '#ffffff';

            newCard.querySelector('.img-preview-thumb').classList.add('hidden');
            newCard.querySelector('.img-icon-placeholder').classList.remove('hidden');

            linksContainer.appendChild(newCard);
            updatePreview();
        });

        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-6 right-6 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-pulse z-50';
            toast.innerText = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        function copyLink() {
            const userId = document.querySelector('button[onclick="copyLink()"]')?.getAttribute('data-user-id');
            if (!userId) {
                showToast('Erro ao copiar link!');
                return;
            }
            
            const url = "{{ route('linktree.show', Auth::id()) }}";
            
            navigator.clipboard.writeText(url).then(() => {
                showToast('✓ Link copiado com sucesso! Compartilhe no Instagram.');
            }).catch(() => {
                showToast('Erro ao copiar. Tente novamente.');
            });
        }

        updatePreview();
    </script>
    
</x-app-layout>