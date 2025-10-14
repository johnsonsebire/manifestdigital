@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('forms.submit', $form->slug) }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    @foreach($form->fields as $field)
        <div class="form-group">
            @switch($field->type)
                @case('text')
                    <label for="{{ $field->name }}" class="form-label">
                        {{ $field->label }} 
                        @if($field->is_required) <span class="required">*</span> @endif
                    </label>
                    <input type="text" 
                           id="{{ $field->name }}" 
                           name="{{ $field->name }}" 
                           class="form-control @error($field->name) is-invalid @enderror" 
                           value="{{ old($field->name) }}"
                           placeholder="{{ $field->placeholder }}"
                           @if($field->is_required) required @endif>
                    @if($field->help_text)
                        <small class="form-text text-muted">{{ $field->help_text }}</small>
                    @endif
                    @error($field->name)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @break
                    
                @case('textarea')
                    <label for="{{ $field->name }}" class="form-label">
                        {{ $field->label }} 
                        @if($field->is_required) <span class="required">*</span> @endif
                    </label>
                    <textarea id="{{ $field->name }}" 
                              name="{{ $field->name }}" 
                              class="form-control @error($field->name) is-invalid @enderror" 
                              rows="4"
                              placeholder="{{ $field->placeholder }}"
                              @if($field->is_required) required @endif>{{ old($field->name) }}</textarea>
                    @if($field->help_text)
                        <small class="form-text text-muted">{{ $field->help_text }}</small>
                    @endif
                    @error($field->name)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @break
                    
                @case('email')
                    <label for="{{ $field->name }}" class="form-label">
                        {{ $field->label }} 
                        @if($field->is_required) <span class="required">*</span> @endif
                    </label>
                    <input type="email" 
                           id="{{ $field->name }}" 
                           name="{{ $field->name }}" 
                           class="form-control @error($field->name) is-invalid @enderror" 
                           value="{{ old($field->name) }}"
                           placeholder="{{ $field->placeholder }}"
                           @if($field->is_required) required @endif>
                    @if($field->help_text)
                        <small class="form-text text-muted">{{ $field->help_text }}</small>
                    @endif
                    @error($field->name)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @break
                    
                @case('select')
                    <label for="{{ $field->name }}" class="form-label">
                        {{ $field->label }} 
                        @if($field->is_required) <span class="required">*</span> @endif
                    </label>
                    <select id="{{ $field->name }}" 
                            name="{{ $field->name }}" 
                            class="form-select @error($field->name) is-invalid @enderror"
                            @if($field->is_required) required @endif>
                        <option value="">Select an option</option>
                        @if(is_array($field->options) && !empty($field->options))
                            @foreach($field->options as $option => $label)
                                <option value="{{ $option }}" @selected(old($field->name) == $option)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @if($field->help_text)
                        <small class="form-text text-muted">{{ $field->help_text }}</small>
                    @endif
                    @error($field->name)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @break
                    
                @case('checkbox')
                    <div class="form-check">
                        <input type="checkbox" 
                               id="{{ $field->name }}" 
                               name="{{ $field->name }}" 
                               class="form-check-input @error($field->name) is-invalid @enderror" 
                               value="1" 
                               @checked(old($field->name))
                               @if($field->is_required) required @endif>
                        <label for="{{ $field->name }}" class="form-check-label">
                            {{ $field->label }}
                            @if($field->is_required) <span class="required">*</span> @endif
                        </label>
                    </div>
                    @if($field->help_text)
                        <small class="form-text text-muted">{{ $field->help_text }}</small>
                    @endif
                    @error($field->name)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @break
                    
                @case('radio')
                    <fieldset>
                        <legend class="form-label">
                            {{ $field->label }}
                            @if($field->is_required) <span class="required">*</span> @endif
                        </legend>
                        
                        @if(is_array($field->options) && !empty($field->options))
                            @foreach($field->options as $option => $label)
                                <div class="form-check">
                                    <input type="radio" 
                                           id="{{ $field->name }}_{{ $option }}" 
                                           name="{{ $field->name }}" 
                                           class="form-check-input @error($field->name) is-invalid @enderror" 
                                           value="{{ $option }}" 
                                           @checked(old($field->name) == $option)
                                           @if($field->is_required) required @endif>
                                    <label for="{{ $field->name }}_{{ $option }}" class="form-check-label">{{ $label }}</label>
                                </div>
                            @endforeach
                        @endif
                    </fieldset>
                    @if($field->help_text)
                        <small class="form-text text-muted">{{ $field->help_text }}</small>
                    @endif
                    @error($field->name)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @break
                    
                @case('file')
                    <label for="{{ $field->name }}" class="form-label">
                        {{ $field->label }}
                        @if($field->is_required) <span class="required">*</span> @endif
                    </label>
                    <input type="file" 
                           id="{{ $field->name }}" 
                           name="{{ $field->name }}" 
                           class="form-control @error($field->name) is-invalid @enderror"
                           @if($field->is_required) required @endif>
                    @if($field->help_text)
                        <small class="form-text text-muted">{{ $field->help_text }}</small>
                    @endif
                    @error($field->name)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @break
                    
                @case('date')
                    <label for="{{ $field->name }}" class="form-label">
                        {{ $field->label }}
                        @if($field->is_required) <span class="required">*</span> @endif
                    </label>
                    <input type="date" 
                           id="{{ $field->name }}" 
                           name="{{ $field->name }}" 
                           class="form-control @error($field->name) is-invalid @enderror" 
                           value="{{ old($field->name) }}"
                           @if($field->is_required) required @endif>
                    @if($field->help_text)
                        <small class="form-text text-muted">{{ $field->help_text }}</small>
                    @endif
                    @error($field->name)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @break
                    
                @case('number')
                    <label for="{{ $field->name }}" class="form-label">
                        {{ $field->label }}
                        @if($field->is_required) <span class="required">*</span> @endif
                    </label>
                    <input type="number" 
                           id="{{ $field->name }}" 
                           name="{{ $field->name }}" 
                           class="form-control @error($field->name) is-invalid @enderror" 
                           value="{{ old($field->name) }}"
                           placeholder="{{ $field->placeholder }}"
                           @if($field->is_required) required @endif>
                    @if($field->help_text)
                        <small class="form-text text-muted">{{ $field->help_text }}</small>
                    @endif
                    @error($field->name)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @break
                    
                @case('hidden')
                    <input type="hidden" 
                           id="{{ $field->name }}" 
                           name="{{ $field->name }}" 
                           value="{{ old($field->name, $field->value ?? '') }}">
                    @break
                    
                @default
                    <label for="{{ $field->name }}" class="form-label">
                        {{ $field->label }}
                        @if($field->is_required) <span class="required">*</span> @endif
                    </label>
                    <input type="text" 
                           id="{{ $field->name }}" 
                           name="{{ $field->name }}" 
                           class="form-control @error($field->name) is-invalid @enderror" 
                           value="{{ old($field->name) }}"
                           placeholder="{{ $field->placeholder }}"
                           @if($field->is_required) required @endif>
                    @if($field->help_text)
                        <small class="form-text text-muted">{{ $field->help_text }}</small>
                    @endif
                    @error($field->name)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
            @endswitch
        </div>
    @endforeach
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary btn-lg">{{ $form->submit_button_text }}</button>
    </div>
</form>

<style>
    .form-group {
        margin-bottom: 24px;
    }
    
    .form-control, .form-select {
        width: 100%;
        padding: 16px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-family: 'Anybody', sans-serif;
        font-size: 16px;
        color: #1a1a1a;
        background: #fff;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #FF4900;
        box-shadow: 0 0 0 3px rgba(255, 73, 0, 0.1);
    }
    
    .required {
        color: #FF4900;
        font-weight: bold;
    }
    
    .form-actions {
        margin-top: 40px;
        text-align: center;
        display: flex;
        justify-content: center;
        gap: 20px;
    }
    
    .form-label {
        font-family: 'Anybody', sans-serif;
        font-weight: 600;
        font-size: 14px;
        color: #1a1a1a;
        margin-bottom: 8px;
        display: block;
    }
    
    /* Match buttons with template styling */
    .btn-primary { 
        background: #000000; 
        color: #FFFCFA; 
        font-weight: 700; 
        font-size: 17px; 
        line-height: 1.2; 
        padding: 12px 24px; 
        min-width: 140px; 
        height: 57px; 
        border-radius: 12px; 
        border: none;
        display: inline-flex; 
        align-items: center; 
        justify-content: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);
        box-shadow: 0 6px 20px rgba(255, 73, 0, 0.3);
        transform: translateY(-2px);
        color: #FFFFFF;
    }
    
    .alert {
        padding: 20px;
        margin-bottom: 30px;
        border-radius: 12px;
        font-family: 'Anybody', sans-serif;
    }
    
    .alert-success {
        background-color: #d1e7dd;
        border: 2px solid #badbcc;
        color: #0f5132;
        box-shadow: 0 4px 15px rgba(15, 81, 50, 0.1);
    }
    
    .alert-danger {
        background-color: #f8d7da;
        border: 2px solid #f5c2c7;
        color: #842029;
        box-shadow: 0 4px 15px rgba(132, 32, 41, 0.1);
    }
</style>