@props([
    'member' => [
        'id' => '',
        'photo' => null,
        'name' => '',
        'role' => '',
        'social' => [
            'linkedin' => null,
            'twitter' => null,
            'github' => null,
            'dribbble' => null,
            'behance' => null,
            'email' => null
        ]
    ]
])

<div class="photo-team-member" data-member="{{ $member['id'] }}">
    <div class="member-image-container">
        @if($member['photo'])
            <img src="{{ asset($member['photo']) }}" alt="{{ $member['name'] }}" class="member-image">
        @else
            <div class="member-image placeholder-image">
                <i class="fas fa-user"></i>
            </div>
        @endif
        <div class="member-hover-overlay">
            <div class="member-info-overlay">
                <h3 class="overlay-name">{{ $member['name'] }}</h3>
                <p class="overlay-role">{{ $member['role'] }}</p>
                <div class="overlay-social">
                    @if($member['social']['linkedin'])
                        <a href="{{ $member['social']['linkedin'] }}" class="overlay-social-link" aria-label="LinkedIn">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    @endif
                    @if($member['social']['twitter'])
                        <a href="{{ $member['social']['twitter'] }}" class="overlay-social-link" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                    @endif
                    @if($member['social']['github'])
                        <a href="{{ $member['social']['github'] }}" class="overlay-social-link" aria-label="GitHub">
                            <i class="fab fa-github"></i>
                        </a>
                    @endif
                    @if($member['social']['dribbble'])
                        <a href="{{ $member['social']['dribbble'] }}" class="overlay-social-link" aria-label="Dribbble">
                            <i class="fab fa-dribbble"></i>
                        </a>
                    @endif
                    @if($member['social']['behance'])
                        <a href="{{ $member['social']['behance'] }}" class="overlay-social-link" aria-label="Behance">
                            <i class="fab fa-behance"></i>
                        </a>
                    @endif
                    @if($member['social']['email'])
                        <a href="mailto:{{ $member['social']['email'] }}" class="overlay-social-link" aria-label="Email">
                            <i class="fas fa-envelope"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.photo-team-member {
    cursor: pointer;
    transition: transform 0.3s ease;
}

.photo-team-member:hover {
    transform: translateY(-5px);
}

.member-image-container {
    position: relative;
    width: 100%;
    aspect-ratio: 1;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.photo-team-member:hover .member-image-container {
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.member-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.placeholder-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    color: white;
    background: linear-gradient(135deg, #FF4900, #FF6B3D);
}

.photo-team-member:hover .member-image {
    transform: scale(1.05);
}

.member-hover-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 73, 0, 0.9), rgba(255, 107, 61, 0.9));
    opacity: 0;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.photo-team-member:hover .member-hover-overlay {
    opacity: 1;
}

.member-info-overlay {
    text-align: center;
    color: white;
    transform: translateY(20px);
    transition: transform 0.3s ease 0.1s;
}

.photo-team-member:hover .member-info-overlay {
    transform: translateY(0);
}

.overlay-name {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
    line-height: 1.2;
}

.overlay-role {
    font-size: 1rem;
    opacity: 0.9;
    margin: 0 0 1.5rem 0;
    font-weight: 400;
}

.overlay-social {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.overlay-social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    color: white;
    text-decoration: none;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.overlay-social-link:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
    color: white;
}

@media (max-width: 768px) {
    .overlay-name {
        font-size: 1.3rem;
    }
    
    .overlay-role {
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .overlay-social-link {
        width: 35px;
        height: 35px;
        font-size: 1rem;
    }
}
</style>