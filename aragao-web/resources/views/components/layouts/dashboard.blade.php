<x-layouts.app>
    <div class="drawer lg:drawer-open">
        <input type="checkbox" class="drawer-toggle" id="drawerCheck" />
        <div class="drawer-content overflow-y-auto pt-16 pb-16 lg:p-0 h-screen">
            <div class="navbar shadow bg-white fixed top-0 left-0 w-full lg:hidden z-10">
                <div class="navbar-start">
                    <label for="drawerCheck" class="btn btn-ghost">
                        <i class="fa-solid fa-bars"></i>
                    </label>
                </div>

                <div class="navbar-center">
                    <img src="{{ asset('/images/logo_square.webp') }}" class="w-10" />
                </div>

                <div class="navbar-end">
                    <div class="dropdown dropdown-end sm:hidden">
                        <button class="btn btn-ghost">
                            <i class="fa-regular fa-circle-user text-xl"></i>
                        </button>

                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                            <li>
                                <a href="{{ route('politica-privacidade') }}" target="_blank">
                                    <i class="fa-solid fa-scale-balanced"></i>
                                    <span>Politica de privacidade</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('dashboard.minha-conta') }}" onclick="initLoading()">
                                    <i class="fa-solid fa-circle-user"></i>
                                    <span>Minha conta</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('dashboard.logout') }}" onclick="initLoading()">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                    <span>Sair</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex flex-col p-3 min-h-full">
                <div id="app-main-content" class="bg-white p-5 shadow-sm flex-grow min-h-full">
                    {{ $slot }}
                </div>
            </div>

            <div class="btm-nav sm:hidden border-t">
                @if (auth()->user()->type !== 'client')
                    <a href="{{ route('dashboard.home') }}" onclick="initLoading()"
                        class="{{ request()->route()->getName() == 'dashboard.home'? 'active text-primary': '' }}">
                        <i class="fa-solid fa-house"></i>
                        <span class="text-xs">Inicio</span>
                    </a>
                @endif

                <a href="{{ route('dashboard.obras') }}" onclick="initLoading()"
                    class="{{ request()->route()->getName() == 'dashboard.obras'? 'active text-primary': '' }}">
                    <i class="fa-solid fa-person-digging"></i>
                    <span class="text-xs">Obras</span>
                </a>

                <a href="{{ route('dashboard.reunioes') }}" onclick="initLoading()"
                    class="{{ request()->route()->getName() == 'dashboard.reunioes'? 'active text-primary': '' }}">
                    <i class="fa-solid fa-video"></i>
                    <span class="text-xs">Reuniões</span>
                </a>

                <a href="{{ route('dashboard.chat') }}" onclick="initLoading()"
                    class="{{ request()->route()->getName() == 'dashboard.chat'? 'active text-primary': '' }}">
                    <i class="fa-solid fa-message"></i>
                    <span class="text-xs">Chat</span>
                </a>
            </div>
        </div>

        <div class="drawer-side z-20">
            <label for="drawerCheck" class="drawer-overlay"></label>

            <ul class="menu p-4 w-72 min-h-full bg-zinc-900 text-base-100">
                <div class="mb-5">
                    <img src="{{ asset('/images/big_logo_white.webp') }}" alt="Aragão Construtora"
                        class="w-28 mx-auto" />
                </div>

                @if (auth()->user()->type !== 'client')
                    <li>
                        <x-components.dashboard.menu.link route="dashboard.home" icon="fa-solid fa-house" text="Início" />
                    </li>
                @endif

                @if (auth()->user()->type == 'admin' || auth()->user()->engineer_admin)
                    <li>
                        <x-components.dashboard.menu.link route="dashboard.usuarios" icon="fa-solid fa-users"
                            text="Usuários" />
                    </li>

                    <li>
                        <x-components.dashboard.menu.link route="dashboard.engenheiros" icon="fa-solid fa-house-user"
                            text="Profissionais" />
                    </li>

                    <li>
                        <x-components.dashboard.menu.link route="dashboard.clientes" icon="fa-solid fa-user-tie"
                            text="Clientes" />
                    </li>
                @endif

                <li>
                    <x-components.dashboard.menu.link route="dashboard.obras" icon="fa-solid fa-person-digging"
                        text="Obras" />
                </li>

                <li>
                    <x-components.dashboard.menu.link route="dashboard.reunioes" icon="fa-solid fa-video"
                        text="Reuniões" />
                </li>

                <li>
                    @if (auth()->user()->unviewed_messages > 0)
                        <x-components.dashboard.menu.link route="dashboard.chat" icon="fa-solid fa-message" text="Chat"
                            badge="{{ auth()->user()->unviewed_messages }}" />
                    @else
                        <x-components.dashboard.menu.link route="dashboard.chat" icon="fa-solid fa-message" text="Chat" />
                    @endif
                </li>

                @if (auth()->user()->type == 'admin' || auth()->user()->engineer_admin)
                    <li>
                        <x-components.dashboard.menu.linkDownload route="dashboard.baixar-apk-funcionario" icon="fa-solid fa-download"
                            text="App Funcionário" />
                    </li>
                @endif

                <div class="mt-auto">
                    <div class="flex items-center gap-3 p-3">
                        <div class="avatar placeholder">
                            <div class="w-8 bg-primary rounded-full">
                                <span>{{ auth()->user()->name_sigla }}</span>
                            </div>
                        </div>
                        <span>{{ auth()->user()->name }}</span>
                    </div>

                    <li>
                        <x-components.dashboard.menu.link route="politica-privacidade" icon="fa-solid fa-scale-balanced"
                            text="Politica de privacidade" blank />
                    </li>

                    <li>
                        <x-components.dashboard.menu.link route="dashboard.minha-conta" icon="fa-solid fa-circle-user"
                            text="Minha conta" />
                    </li>

                    <li>
                        <x-components.dashboard.menu.link route="dashboard.logout"
                            icon="fa-solid fa-arrow-right-from-bracket" text="Sair" />
                    </li>
                </div>
            </ul>
        </div>
    </div>

    @push('scripts')
        @vite('resources/sass/dashboard.scss')
    @endpush
</x-layouts.app>
