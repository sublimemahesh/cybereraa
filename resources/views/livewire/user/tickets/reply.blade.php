<div>
    @forelse ($ticket->replies as $reply)
        <div class="row">
            <div class="col ">
                <p class="font-weight-bold">
                    @if (Auth::user()->id === $reply->user_id)
                        <a href="javascript:void(0)">You</a>
                    @else
                        @if ($reply->admin_id)
                            @if (Auth::user()->id === $reply->admin_id)
                                <a href="javascript:void(0)">You</a>
                            @else
                                <a href="mailto:{{ $reply->admin->email }}">
                                    {{ $reply->admin->name }}
                                </a>
                            @endif
                        @else
                            <a href="mailto:{{ $reply->user->email }}">
                                {{ $reply->user->name }}
                            </a>
                        @endif
                    @endif
                    ({{ $reply->created_at }})
                </p>
                <p class="pre-txt">{{ $reply->reply }}</p>
                @if (!empty($reply->attachment))
                    <p>
                        <img src="https://img.icons8.com/fluency/48/000000/pdf-mail.png" alt=""/>
                        <a href="{{ storage('supports/tickets/reply/' . $reply->attachment) }}" target="blank">
                            View File {{ $reply->attachment }}
                        </a>
                    </p>
                @endif
            </div>
        </div>
        <hr/>
    @empty
        <div class="row">
            <div class="col">
                <p>There are no replies.</p>
            </div>
        </div>
        <hr/>
    @endforelse
    @can('reply', $ticket)
        <form wire:submit.prevent="reply" method="POST">
            @csrf
            <div class="form-group mb-2">
                <label for="comment_text">Leave a Reply</label>
                <textarea wire:model.lazy="reply.reply" class="form-control" id="comment_text" name="reply_body" rows="4" required></textarea>
                @error('reply.reply')
                <span class="text-danger mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group my-2">
                <label class="control-label" for="attachment">Attach Files</label>
                <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <!-- File Input -->
                    <input wire:model="attachment" id="attachment" class="form-control" type="file" accept="image/*,application/pdf">
                    <input id="old_attachment" type="hidden" value="{{ $reply->attachment }}">
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
                    @elseif(!$attachment && $reply->attachment)
                        @php
                            $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg'];
                            $explodeImage = explode('.', $reply->attachment);
                            $extension = end($explodeImage);
                        @endphp
                        @if (in_array($extension, $imageExtensions,true))
                            <img class="img-thumbnail mt-2" src="{{ storage('supports/tickets/' . $reply->attachment) }}" style="width:300px" alt="">
                        @else
                            <b>
                                Current PDF : <br>
                                <img src="https://img.icons8.com/fluency/48/000000/pdf-mail.png" alt=""/>
                            </b>
                            <a href="{{ storage('supports/tickets/' . $reply->attachment) }}" target="blank">
                                {{ $reply->attachment }}
                            </a>
                        @endif
                    @endif
                @endif
            </div>
            <button type="submit" class="btn btn-dark btn-rounded mt-2">Reply</button>
        </form>
    @endcan
</div>
