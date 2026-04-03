<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1e293b; line-height: 1.5; }
        .header { background: #134e4a; color: white; padding: 30px 40px; }
        .header h1 { font-size: 24px; margin-bottom: 5px; }
        .header p { font-size: 11px; opacity: 0.85; }
        .header .contact { margin-top: 10px; font-size: 10px; }
        .header .contact span { margin-right: 15px; }
        .content { padding: 25px 40px; }
        .section { margin-bottom: 20px; }
        .section-title { font-size: 14px; font-weight: bold; color: #0d9488; border-bottom: 2px solid #0d9488; padding-bottom: 5px; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; }
        .item { margin-bottom: 12px; }
        .item-header { display: flex; justify-content: space-between; margin-bottom: 3px; }
        .item-title { font-weight: bold; font-size: 12px; }
        .item-subtitle { color: #64748b; font-size: 10px; }
        .item-period { color: #64748b; font-size: 10px; text-align: right; }
        .item-desc { color: #475569; font-size: 10px; margin-top: 3px; }
        .skills-list { display: flex; flex-wrap: wrap; gap: 6px; }
        .skill-tag { background: #f0fdfa; color: #0d9488; padding: 3px 10px; border-radius: 4px; font-size: 10px; border: 1px solid #ccfbf1; }
        .summary { color: #475569; font-size: 11px; line-height: 1.6; }
        .footer { text-align: center; color: #94a3b8; font-size: 8px; margin-top: 30px; padding-top: 10px; border-top: 1px solid #e2e8f0; }
        table { width: 100%; }
        td { vertical-align: top; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $data['full_name'] }}</h1>
        <div class="contact">
            @if($data['email'])<span>✉ {{ $data['email'] }}</span>@endif
            @if($data['phone'])<span>📞 {{ $data['phone'] }}</span>@endif
            @if($data['city'])<span>📍 {{ $data['city'] }}</span>@endif
        </div>
    </div>

    <div class="content">
        @if(!empty($data['summary']))
        <div class="section">
            <div class="section-title">Profesionalni rezime</div>
            <p class="summary">{{ $data['summary'] }}</p>
        </div>
        @endif

        @if(!empty($data['education']))
        <div class="section">
            <div class="section-title">Obrazovanje</div>
            @foreach($data['education'] as $edu)
                @if(!empty($edu['institution']))
                <div class="item">
                    <table><tr>
                        <td><span class="item-title">{{ $edu['institution'] }}</span><br><span class="item-subtitle">{{ $edu['degree'] ?? '' }}</span></td>
                        <td style="text-align:right"><span class="item-period">{{ $edu['year'] ?? '' }}</span></td>
                    </tr></table>
                </div>
                @endif
            @endforeach
        </div>
        @endif

        @if(!empty($data['experience']))
        <div class="section">
            <div class="section-title">Radno iskustvo</div>
            @foreach($data['experience'] as $exp)
                @if(!empty($exp['company']) || !empty($exp['position']))
                <div class="item">
                    <table><tr>
                        <td><span class="item-title">{{ $exp['position'] ?? '' }}</span><br><span class="item-subtitle">{{ $exp['company'] ?? '' }}</span></td>
                        <td style="text-align:right"><span class="item-period">{{ $exp['period'] ?? '' }}</span></td>
                    </tr></table>
                    @if(!empty($exp['description']))
                        <p class="item-desc">{{ $exp['description'] }}</p>
                    @endif
                </div>
                @endif
            @endforeach
        </div>
        @endif

        @if(!empty($data['skills']))
        <div class="section">
            <div class="section-title">Veštine</div>
            <div class="skills-list">
                @foreach(explode(',', $data['skills']) as $skill)
                    <span class="skill-tag">{{ trim($skill) }}</span>
                @endforeach
            </div>
        </div>
        @endif

        @if(!empty($data['languages']))
        <div class="section">
            <div class="section-title">Jezici</div>
            <p>{{ $data['languages'] }}</p>
        </div>
        @endif
    </div>

    <div class="footer">Generisano putem Gaudeamus CV Builder &bull; {{ date('d.m.Y') }}</div>
</body>
</html>
