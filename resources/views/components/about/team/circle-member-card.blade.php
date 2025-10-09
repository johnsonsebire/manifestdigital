@props([
    'member' => [
        'id' => '',
        'photo' => null,
        'name' => '',
        'role' => '',
        'email' => '',
        'social' => [
            'linkedin' => null,
            'twitter' => null,
            'github' => null,
            'dribbble' => null,
            'behance' => null,
            'stackoverflow' => null
        ]
    ]
])

<div class="circle-team-member" data-member="{{ $member['id'] }}">
    <div class="circle-photo-container">
        @if($member['photo'])
            <img src="{{ asset($member['photo']) }}" alt="{{ $member['name'] }}" class="circle-photo">
        @else
            <div class="circle-photo placeholder-photo">
                <i class="fas fa-user"></i>
            </div>
        @endif
        <div class="circle-overlay">
            <i class="fas fa-eye"></i>
        </div>
    </div>
    <div class="circle-member-info">
        <h3 class="circle-name">{{ $member['name'] }}</h3>
        <p class="circle-role">{{ $member['role'] }}</p>
        @if($member['email'])
            <a href="mailto:{{ $member['email'] }}" class="circle-email">
                <i class="fas fa-envelope"></i>
                {{ $member['email'] }}
            </a>
        @endif
        <div class="circle-social">
            @if($member['social']['linkedin'])
                <a href="{{ $member['social']['linkedin'] }}" class="circle-social-link" aria-label="LinkedIn">
                    <i class="fab fa-linkedin"></i>
                </a>
            @endif
            @if($member['social']['twitter'])
                <a href="{{ $member['social']['twitter'] }}" class="circle-social-link" aria-label="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
            @endif
            @if($member['social']['github'])
                <a href="{{ $member['social']['github'] }}" class="circle-social-link" aria-label="GitHub">
                    <i class="fab fa-github"></i>
                </a>
            @endif
            @if($member['social']['dribbble'])
                <a href="{{ $member['social']['dribbble'] }}" class="circle-social-link" aria-label="Dribbble">
                    <i class="fab fa-dribbble"></i>
                </a>
            @endif
            @if($member['social']['behance'])
                <a href="{{ $member['social']['behance'] }}" class="circle-social-link" aria-label="Behance">
                    <i class="fab fa-behance"></i>
                </a>
            @endif
            @if($member['social']['stackoverflow'])
                <a href="{{ $member['social']['stackoverflow'] }}" class="circle-social-link" aria-label="Stack Overflow">
                    <i class="fab fa-stack-overflow"></i>
                </a>
            @endif
        </div>
    </div>
</div>

<style>
.circle-team-member {
    text-align: center;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.circle-team-member:hover {
    transform: translateY(-5px);
}

.circle-photo-container {
    position: relative;
    width: 160px;
    height: 160px;
    margin: 0 auto 1.5rem;
    border-radius: 50%;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 4px solid #f8f9fa;
}

.circle-team-member:hover .circle-photo-container {
    box-shadow: 0 12px 35px rgba(255, 73, 0, 0.15);
    border-color: #FF4900;
}

.circle-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.placeholder-photo {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: white;
    background: linear-gradient(135deg, #FF4900, #FF6B3D);
}

.circle-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 73, 0, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    color: white;
    font-size: 1.5rem;
}

.circle-team-member:hover .circle-overlay {
    opacity: 1;
}

.circle-team-member:hover .circle-photo {
    transform: scale(1.1);
}

.circle-member-info {
    padding: 0 1rem;
}

.circle-name {
    font-size: 1.4rem;
    font-weight: 700;
    color: #333;
    margin: 0 0 0.5rem 0;
    line-height: 1.3;
}

.circle-role {
    font-size: 1rem;
    color: #666;
    margin: 0 0 1rem 0;
    font-weight: 400;
}

.circle-email {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #FF4900;
    text-decoration: none;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    background: rgba(255, 73, 0, 0.1);
    transition: all 0.3s ease;
    font-weight: 500;
}

.circle-email:hover {
    background: rgba(255, 73, 0, 0.15);
    color: #FF4900;
    transform: translateY(-2px);
}

.circle-social {
    display: flex;
    justify-content: center;
    gap: 0.8rem;
    margin-top: 1rem;
}

.circle-social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: #f8f9fa;
    border-radius: 50%;
    color: #666;
    text-decoration: none;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.circle-social-link:hover {
    background: #FF4900;
    color: white;
    transform: translateY(-2px);
    border-color: #FF4900;
    box-shadow: 0 4px 15px rgba(255, 73, 0, 0.3);
}

@media (max-width: 768px) {
    .circle-photo-container {
        width: 140px;
        height: 140px;
    }
    
    .circle-name {
        font-size: 1.2rem;
    }
    
    .circle-role {
        font-size: 0.9rem;
    }
    
    .circle-social-link {
        width: 35px;
        height: 35px;
        font-size: 1rem;
    }
}
</style>