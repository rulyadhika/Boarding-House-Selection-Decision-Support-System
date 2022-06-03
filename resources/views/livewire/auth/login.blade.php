   <div class="row justify-content-center">
       <x-slot name="title">{{ $title }}</x-slot>
       <div class="col-lg-6">
           <div class="card o-hidden border-0 shadow-lg my-5">
               <div class="card-body p-0">
                   <form wire:submit.prevent class="user">
                       <div class="p-5">
                           <div class="text-center">
                               <h1 class="h4 text-gray-900 ">Cari Kost - Login</h1>
                               <small class="d-block mb-4">Selamat Datang Kembali!</small>
                           </div>

                           @if (session()->has('error'))
                               <div class="alert alert-danger" role="alert">
                                   {{ session()->get('error') }}
                               </div>
                           @endif

                           @if (session()->has('success'))
                               <div class="alert alert-success" role="alert">
                                   {{ session()->get('success') }}
                               </div>
                           @endif


                           <div class="form-group">
                               <input id="username" type="text" placeholder="Username"
                                   class="form-control form-control-user @error('username') is-invalid @enderror"
                                   wire:model.defer="username" tabindex="1" autofocus value="{{ old('username') }}">
                               @error('username')
                                   <div class="invalid-feedback">
                                       {{ $message }}
                                   </div>
                               @enderror
                           </div>

                           <div class="form-group">
                               <div class="d-block">
                               </div>
                               <input id="password" type="password" placeholder="Password"
                                   class="form-control form-control-user @error('password') is-invalid @enderror"
                                   wire:model.defer="password" tabindex="2">
                               @error('password')
                                   <div class="invalid-feedback">
                                       {{ $message }}
                                   </div>
                               @enderror
                           </div>

                           <div class="form-group mb-0">
                               <button type="submit" class="btn btn-primary btn-user btn-block" tabindex="4"
                                   wire:click="authenticate">
                                   Login
                               </button>
                           </div>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
