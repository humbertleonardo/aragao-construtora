<div x-data="etapasTabEvolucoes" x-on:clear-file-input="$refs.inputImagens.value = null">
    <x-components.dashboard.navbar.navbar title="Evoluções da obra">
        @if (auth()->user()->type == 'engineer')
            <button class="btn btn-sm btn-primary" x-on:click="$wire.modal = true">Adicionar evolução</button>
        @endif
    </x-components.dashboard.navbar.navbar>

    <div>
        <table class="table table-sm table-zebra">
            <thead>
                <tr class="active">
                    <th>Etapa</th>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($evolucoes as $evolucao)    
                    <tr wire:loading.class="active" wire:target="excluirEvolucao({{ $evolucao->id }})">
                        <td>
                            <strong>{{ "#{$evolucao->etapa->id} - {$evolucao->etapa->nome}" }}</strong>
                        </td>
                        <td>{{ date_format(date_create($evolucao->dt_evolucao), 'd/m/Y') }}</td>
                        <td>
                            <div class="tooltip" data-tip="{{ $evolucao->descricao }}">
                                <span class="block max-w-xs text-ellipsis overflow-hidden whitespace-nowrap">{{ $evolucao->descricao }}</span>
                            </div>
                        </td>
                        <td>
                            <div wire:loading.remove wire:target="excluirEvolucao({{ $evolucao->id }})">
                                <x-components.dashboard.dropdown.dropdown-table class="dropdown-top">
                                    <x-components.dashboard.dropdown.dropdown-item text="Informações" icon="fa-solid fa-circle-info"
                                        x-on:click="setInfoEvolucao({{$evolucao}})" />
    
                                    @if (auth()->user()->type == 'engineer')
                                        <x-components.dashboard.dropdown.dropdown-item text="Editar" icon="fa-solid fa-pen-to-square"
                                            x-on:click="setEditModal({{ $evolucao }}, () => $wire)" />
    
                                        <x-components.dashboard.dropdown.dropdown-item text="Excluir" icon="fa-solid fa-trash"
                                            x-on:click="exclurEvolucao({{ $evolucao }}, () => $wire)" />
                                    @endif
                                </x-components.dashboard.dropdown.dropdown-table>
                            </div>

                            <div wire:loading wire:target="excluirEvolucao({{ $evolucao->id }})">
                                <x-components.loading class="loading-sm" />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal" x-bind:class="{'modal-open': $wire.modal}">
        <form wire:submit.prevent="saveEvolucao" class="modal-box">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg" x-text="`${$wire.editId ? 'Editar' : 'Nova'} evolução`"></h3>

                <button type="button" class="btn btn-sm btn-circle" x-on:click="closeModal(() => $wire)">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div>
                <div class="flex gap-3 mb-2 flex-wrap sm:flex-nowrap">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Etapa <span class="text-red-500">*</span></span>
                        </label>
    
                        <select class="select select-sm select-bordered" required wire:model="inputs.id_etapa">
                            <option value="">SELECIONE</option>
                            @foreach ($etapas as $etapa)
                                <option value="{{ $etapa->id }}">#{{ $etapa->id }} - {{ $etapa->nome }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="form-control">
                        <x-components.input type="date" label="Data da evolução" placeholder="Data da evolução" required
                            class="input-sm" wire:model="inputs.dt_evolucao" name="inputs.dt_evolucao" />
                    </div>
                </div>

                <div class="mb-2">
                    <x-components.input type="textarea" label="Descrição" placeholder="Descrição" required
                        rows="5" class="textarea-sm" wire:model="inputs.descricao" name="inputs.descricao" />
                </div>

                <div>
                    <x-components.input type="file" label="Anexos (apenas imagens)" placeholder="Anexos"
                        class="file-input-sm" accept=".jpg,.png,.webp,.jpeg"
                        multiple wire:model="inputsImages" name="inputsImages" x-ref="inputImagens" />
                </div>

                <template x-if="$wire.editId">
                    <div class="mt-3">
                        <strong class="text-sm">Imagens salvas anteriormente:</strong>
                        <div class="flex overflow-x-auto p-2 gap-3">
                            <template x-for="imagem, i in infoEvolucao?.imagens" x-key="i">
                                <div class="w-28 h-28 relative">
                                    <button type="button" class="btn btn-sm btn-ghost btn-circle absolute"
                                        x-on:click="exclurImagem(imagem.id, () => $wire)">
                                        <i class="fa-solid fa-trash text-red-600"></i>
                                    </button>

                                    <img x-bind:src="imagem.url" class="w-full h-full object-cover rounded-md cursor-pointer"
                                        x-on:click="setModalImage(imagem.url)" />
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <div class="modal-action">
                <button type="submit" class="btn btn-sm btn-primary" wire:loading.attr="disabled" wire:target="saveEvolucao">
                    <div wire:loading wire:target="saveEvolucao">
                        <x-components.loading class="loading-xs" />
                    </div>
                    <span>Salvar</span>
                </button>
            </div>
        </form>
    </div>

    <div class="modal" x-bind:class="{'modal-open': modalInfoEvolucao}">
        <div class="modal-box">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg">Informações da evolução</h3>

                <button type="button" class="btn btn-sm btn-circle" x-on:click="modalInfoEvolucao = false">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div>
                <div class="mb-1">
                    <strong class="text-sm">Etapa:</strong>
                    <span class="text-sm" x-text="`#${infoEvolucao?.etapa.id} - ${infoEvolucao?.etapa.nome}`"></span>
                </div>

                <div class="mb-2">
                    <strong class="text-sm">Data da evolução:</strong>
                    <span class="text-sm" x-text="$store.helpers.formatDate(infoEvolucao?.dt_evolucao)"></span>
                </div>

                <div class="mb-2">
                    <strong class="text-sm">Descrição:</strong>
                    <p class="text-sm" x-text="infoEvolucao?.descricao"></p>
                </div>

                <strong class="text-sm">Imagens:</strong>
                <div class="flex overflow-x-auto p-2 gap-3">
                    <template x-for="imagem, i in infoEvolucao?.imagens" x-key="i">
                        <div class="w-28 h-28 relative">
                            <img x-bind:src="imagem.url" class="w-full h-full object-cover rounded-md cursor-pointer"
                                x-on:click="setModalImage(imagem.url)" />
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" x-bind:class="{'modal-open': modalImage}">
        <div class="modal-box p-0 relative max-w-4xl">
            <button type="button" class="btn btn-sm btn-ghost btn-circle text-white absolute top-3 right-3" x-on:click="modalImage = false">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <img x-bind:src="modalImageSrc" />
        </div>
    </div>
</div>

@push('scripts')
    @vite('resources/js/views/obras/etapas-tabs-evolucoes.js');
@endpush