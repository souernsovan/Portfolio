<x-admin-layout title="Message">
    <div class="surface-1 rounded-xl border p-6">
        <div class="mb-6 flex items-start justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-heading text-lg font-semibold">{{ $message->subject ?: 'No subject' }}</h2>
                    @if($message->replied_at)
                        <span class="badge-accent rounded-full px-2 py-0.5 text-xs">Replied</span>
                    @endif
                </div>
                <p class="text-muted mt-1 text-sm">
                    From <span class="text-body">{{ $message->name }}</span>
                    &lt;<a href="mailto:{{ $message->email }}" class="link-accent">{{ $message->email }}</a>&gt;
                </p>
                <p class="text-faintest mt-1 text-xs">{{ $message->created_at->format('M j, Y \a\t g:i A') }}</p>
            </div>
            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-lg border border-red-500/30 px-4 py-2 text-sm text-red-600 hover:bg-red-500/10 dark:text-red-400">Delete</button>
            </form>
        </div>

        <p class="text-body whitespace-pre-line">{{ $message->message }}</p>
    </div>

    @if(config('mail.default') === 'log')
        <div class="mt-6 rounded-lg border border-amber-500/30 bg-amber-500/10 px-4 py-3 text-sm text-amber-700 dark:text-amber-300">
            Mail is set to the <code class="font-mono">log</code> driver, so replies are written to <code class="font-mono">storage/logs/laravel.log</code> instead of actually being emailed. Configure real SMTP credentials in <code class="font-mono">.env</code> to send for real.
        </div>
    @endif

    @if($message->replied_at)
        <div class="surface-1 mt-6 rounded-xl border p-6">
            <div class="mb-3 flex items-center justify-between">
                <h3 class="text-heading text-sm font-semibold">Your reply</h3>
                <span class="text-faintest text-xs">Sent {{ $message->replied_at->format('M j, Y \a\t g:i A') }}</span>
            </div>
            <div class="text-body prose-reply text-sm">{!! $message->reply_body !!}</div>
        </div>
    @endif

    <div class="surface-1 mt-6 rounded-xl border p-6">
        <h3 class="text-heading mb-4 text-sm font-semibold">{{ $message->replied_at ? 'Send another reply' : 'Reply to '.$message->name }}</h3>
        <form method="POST" action="{{ route('admin.messages.reply', $message) }}">
            @csrf
            <textarea name="reply_body" id="reply_body" rows="6" placeholder="Type your reply&hellip;">{{ old('reply_body') }}</textarea>
            @error('reply_body')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
            <p id="reply_body-empty-error" class="mt-1 hidden text-xs text-red-600 dark:text-red-400">Please write a reply before sending.</p>
            <p class="text-faint mt-2 text-xs">Formatting is supported — bold, links, lists, quotes, tables — and will render in the email your reply sends.</p>

            <button type="submit" class="btn-primary mt-4 rounded-lg px-6 py-2.5 text-sm font-semibold">
                Send reply
            </button>
        </form>
    </div>

    <a href="{{ route('admin.messages.index') }}" class="text-muted mt-6 inline-block text-sm hover:text-neutral-900 dark:hover:text-white">&larr; Back to messages</a>

    <style>
        .prose-reply p { margin: 0 0 0.75em; }
        .prose-reply p:last-child { margin-bottom: 0; }
        .prose-reply ul, .prose-reply ol { margin: 0 0 0.75em; padding-left: 1.5em; }
        .prose-reply a { color: #059669; text-decoration: underline; }
        .ck-editor__editable_inline { min-height: 180px; }

        /* Tailwind's base reset sets h1-h6 to font-size/weight: inherit site-wide, which
           flattens CKEditor's heading styles both while editing and in the saved preview.
           Restore real heading typography inside both contexts. */
        .ck-content h1, .prose-reply h1 { font-size: 1.75em; font-weight: 700; line-height: 1.3; margin: 0.7em 0 0.4em; }
        .ck-content h2, .prose-reply h2 { font-size: 1.5em; font-weight: 700; line-height: 1.3; margin: 0.6em 0 0.4em; }
        .ck-content h3, .prose-reply h3 { font-size: 1.25em; font-weight: 600; line-height: 1.35; margin: 0.5em 0 0.3em; }
        .ck-content h4, .prose-reply h4 { font-size: 1.1em; font-weight: 600; line-height: 1.4; margin: 0.5em 0 0.3em; }
        .ck-content h1:first-child, .prose-reply h1:first-child,
        .ck-content h2:first-child, .prose-reply h2:first-child,
        .ck-content h3:first-child, .prose-reply h3:first-child,
        .ck-content h4:first-child, .prose-reply h4:first-child { margin-top: 0; }

        /* Dark-mode overrides for CKEditor — it ships a light-only UI by default. */
        .dark .ck.ck-editor__main > .ck-editor__editable,
        .dark .ck.ck-content {
            background: #171717;
            color: #e5e5e5;
            border-color: rgba(255, 255, 255, 0.1) !important;
            caret-color: #e5e5e5;
        }
        .dark .ck.ck-editor__editable.ck-focused {
            border-color: rgba(52, 211, 153, 0.5) !important;
            box-shadow: none !important;
        }
        .dark .ck.ck-editor__editable > .ck-placeholder::before {
            color: #737373;
        }
        .dark .ck.ck-toolbar {
            background: #262626;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .dark .ck.ck-toolbar .ck-toolbar__separator {
            background: rgba(255, 255, 255, 0.1);
        }
        .dark .ck.ck-button,
        .dark a.ck.ck-button {
            color: #d4d4d4;
        }
        .dark .ck.ck-button:not(.ck-disabled):hover,
        .dark a.ck.ck-button:not(.ck-disabled):hover {
            background: rgba(255, 255, 255, 0.08);
        }
        .dark .ck.ck-button.ck-on,
        .dark a.ck.ck-button.ck-on {
            background: rgba(52, 211, 153, 0.15);
            color: #34d399;
        }
        .dark .ck.ck-dropdown__panel,
        .dark .ck.ck-balloon-panel,
        .dark .ck.ck-list {
            background: #262626;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #e5e5e5;
        }
        .dark .ck.ck-list__item .ck-button:not(.ck-disabled):hover {
            background: rgba(255, 255, 255, 0.08);
        }
        .dark .ck.ck-labeled-field-view .ck-labeled-field-view__input-wrapper,
        .dark .ck.ck-input {
            background: #171717;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #e5e5e5;
        }
        .dark .ck.ck-heading_dropdown .ck-dropdown__panel .ck-list__item .ck-button__label,
        .dark .ck.ck-list__item .ck-button__label {
            color: #e5e5e5;
        }
        .dark .ck.ck-icon {
            color: inherit;
        }
        .dark .ck.ck-toolbar__separator {
            background: rgba(255, 255, 255, 0.1) !important;
        }
        .dark .ck.ck-editor__top .ck-sticky-panel__content {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .dark .ck-powered-by {
            filter: invert(1) brightness(1.6);
        }
    </style>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const el = document.getElementById('reply_body');
            if (!el || !window.ClassicEditor) return;

            ClassicEditor.create(el, {
                toolbar: [
                    'undo', 'redo', '|',
                    'heading', '|',
                    'bold', 'italic', 'link', '|',
                    'bulletedList', 'numberedList', '|',
                    'blockQuote', 'insertTable', 'horizontalLine', '|',
                    'sourceEditing',
                ],
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells'],
                },
            }).then((editor) => {
                const form = el.form;
                const emptyError = document.getElementById('reply_body-empty-error');

                // CKEditor doesn't write back to the original <textarea> on its own, and
                // native `required` validation can't reliably see a hidden/replaced field,
                // so validate and sync manually before the form actually posts.
                form?.addEventListener('submit', (event) => {
                    const data = editor.getData().trim();

                    if (!data) {
                        event.preventDefault();
                        emptyError?.classList.remove('hidden');
                        editor.editing.view.focus();
                        return;
                    }

                    emptyError?.classList.add('hidden');
                    el.value = data;
                });
            }).catch((error) => console.error(error));
        });
    </script>
</x-admin-layout>
