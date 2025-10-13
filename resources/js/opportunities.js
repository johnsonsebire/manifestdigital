{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "{{ config('app.name') }}",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('images/logos/manifest-logo.svg') }}",
  "sameAs": [
    "https://twitter.com/manifestghana",
    "https://linkedin.com/company/manifest-digital-ghana",
    "https://instagram.com/manifestghana"
  ],
  "jobPosting": [
    {
      "@type": "JobPosting",
      "title": "Senior Full-Stack Developer",
      "description": "Join our development team to build cutting-edge web applications using modern technologies. Lead projects and mentor junior developers.",
      "datePosted": "{{ now()->subDays(3)->toISOString() }}",
      "employmentType": "FULL_TIME",
      "hiringOrganization": {
        "@type": "Organization",
        "name": "{{ config('app.name') }}",
        "sameAs": "{{ url('/') }}"
      },
      "jobLocation": {
        "@type": "Place",
        "address": {
          "@type": "PostalAddress",
          "addressLocality": "Lagos",
          "addressCountry": "NG"
        }
      },
      "baseSalary": {
        "@type": "MonetaryAmount",
        "currency": "NGN",
        "value": {
          "@type": "QuantitativeValue",
          "value": 2500000,
          "unitText": "YEAR"
        }
      }
    },
    {
      "@type": "JobPosting",
      "title": "Senior UI/UX Designer",
      "description": "Create beautiful and intuitive user experiences for web and mobile applications. Work closely with development teams to bring designs to life.",
      "datePosted": "{{ now()->subWeek()->toISOString() }}",
      "employmentType": "FULL_TIME",
      "hiringOrganization": {
        "@type": "Organization",
        "name": "{{ config('app.name') }}",
        "sameAs": "{{ url('/') }}"
      },
      "jobLocation": {
        "@type": "Place",
        "address": {
          "@type": "PostalAddress",
          "addressLocality": "Lagos",
          "addressCountry": "NG"
        }
      }
    }
  ]
}
