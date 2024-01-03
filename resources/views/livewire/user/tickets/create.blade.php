<div class="card">
    <div class="card-body">
        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <form wire:submit.prevent="save" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <label for="category">Category*</label>
                @if($category === 'reschedule-plan')
                    <div class="form-control">Reschedule Plan</div>
                @else
                    <select wire:model.lazy="ticket.support_ticket_category_id" id="category" class="form-control" required>
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                @endif
                @error('ticket.support_ticket_category_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-2">
                <label for="title">Subject*</label>
                <input wire:model.lazy="ticket.subject" type="text" id="title" name="title" class="form-control" required>
                @error('ticket.subject')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-2">
                <label for="content">Body</label>
                <textarea wire:model.lazy="ticket.body" rows="4" id="content" name="content" class="form-control " style="min-height: 150px"></textarea>
                @error('ticket.body')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-2">
                <label class="control-label" for="attachment">Attach Files</label>
                <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <!-- File Input -->
                    <input wire:model="attachment" id="attachment" class="form-control" type="file" accept="image/*,application/pdf">
                    <input id="old_attachment" type="hidden" value="{{ $ticket->attachment }}">
                    <!-- Progress Bar -->
                    <div x-show="isUploading">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                </div>
                @error('attachment')
                <span class="text-danger mt-2">{{ $message }}</span>
                @enderror
                @if (!$errors->has('attachment'))
                    @if ($attachment && $attachment->extension() !== 'pdf')
                        <img class="img-thumbnail mt-2 ml-2" src="{{ $attachment->temporaryUrl() }}" style="width:300px" alt="">
                    @elseif(!$attachment && $ticket->attachment)
                        @php
                            $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg'];
                            $explodeImage = explode('.', $ticket->attachment);
                            $extension = end($explodeImage);
                        @endphp
                        @if (in_array($extension, $imageExtensions,true))
                            <img class="img-thumbnail mt-2" src="{{ storage('supports/tickets/' . $ticket->attachment) }}" style="width:300px" alt="">
                        @else
                            <b>
                                Current PDF : <br>
                                <img src="https://img.icons8.com/fluency/48/000000/pdf-mail.png" alt=""/>
                            </b>
                            <a href="{{ storage('supports/tickets/' . $ticket->attachment) }}" target="blank">
                                {{ $ticket->attachment }}
                            </a>
                        @endif
                    @endif
                @endif
            </div>
            <div>
                <input class="btn btn-success mt-2" type="submit" value="SUBMIT">
            </div>
        </form>
    </div>
</div>
