<?php
$title = "Car Repair Estimate - Check If Your Quote Is Fair | Are They Screwing Me?";
$metaDescription = "Review car repair estimates before you pay. Check typical pricing for brakes, oil changes, engine work, and vehicle maintenance. Upload your mechanic quote to see if you're being overcharged.";
$metaKeywords = 'car repair estimate, vehicle repair cost, auto mechanic quote, car repair pricing, brake repair cost, engine repair estimate';
include __DIR__.'/partials/header.php';
?>
<section class="hero-simple">
  <div class="container">
    <span class="eyebrow">Car Repair Estimate Guide</span>
    <h1>How to know if a car repair estimate is fair</h1>
    <p class="lead">Car repair estimates can hide inflated labor rates, unnecessary services, and vague parts pricing. Before you approve the work, make sure you're getting transparent pricing and fair market rates.</p>
    <div class="hero-actions">
      <a href="/upload?category=mechanic" class="btn">Upload your car repair estimate</a>
      <a href="/signup" class="btn btn-outline">Get 2 free checks</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="quote-box" style="max-width: 900px; margin: 0 auto;">
      <div class="section-header" style="margin-bottom:18px">
        <h2>Typical car repair estimate ranges</h2>
        <p>Most car repairs cost between <strong>$150 to $1,000</strong>, with major work like transmission or engine repair running significantly higher.</p>
      </div>
      
      <h3 style="margin-bottom:12px">Common car repair services & typical costs</h3>
      <ul class="list">
        <li><strong>Oil change:</strong> $40–$100</li>
        <li><strong>Tire rotation:</strong> $35–$75</li>
        <li><strong>Brake pads replacement:</strong> $150–$350 per axle</li>
        <li><strong>Brake pads + rotors:</strong> $300–$600 per axle</li>
        <li><strong>Battery replacement:</strong> $100–$250</li>
        <li><strong>Air filter replacement:</strong> $20–$80</li>
        <li><strong>Timing belt replacement:</strong> $500–$1,200</li>
        <li><strong>Transmission service:</strong> $150–$400</li>
        <li><strong>Check engine light diagnosis:</strong> $80–$150</li>
      </ul>

      <div class="divider"></div>

      <h3 style="margin-bottom:12px">Is your car repair quote too high?</h3>
      <p class="muted">Watch out for these red flags in car repair estimates:</p>
      <ul class="list">
        <li>No breakdown between labor and parts costs</li>
        <li>Pushed toward expensive services during routine maintenance</li>
        <li>Parts without OEM vs. aftermarket distinction or pricing transparency</li>
        <li>High "shop supplies" or "environmental fees" with no explanation</li>
        <li>Upselling services not due per your owner's manual schedule</li>
      </ul>

      <div class="divider"></div>

      <div class="hero-actions" style="justify-content: flex-start; margin-top: 24px;">
        <a href="/upload?category=mechanic" class="btn">Check if you're being overcharged</a>
      </div>
    </div>
  </div>
</section>

<section class="section section-tight">
  <div class="container">
    <div class="section-header compact-center">
      <h2>What affects car repair estimate costs?</h2>
      <p>Understanding these factors helps you evaluate whether your quote is reasonable.</p>
    </div>
    <div class="grid-3">
      <div class="card card-outline">
        <h3>Labor rates & time</h3>
        <p class="muted">Shop rates range from $80-$150/hour. Dealerships charge 20-40% more than independent shops. Flat-rate guides may inflate time vs. actual work required.</p>
      </div>
      <div class="card card-outline">
        <h3>OEM vs. aftermarket parts</h3>
        <p class="muted">OEM (dealer) parts cost 30-100% more. Quality aftermarket brands (Bosch, Moog, ACDelco) perform identically and carry warranties. Ask before assuming OEM is required.</p>
      </div>
      <div class="card card-outline">
        <h3>Vehicle make & model</h3>
        <p class="muted">Luxury, foreign, and hybrid cars cost more due to specialized parts and training. Older vehicles may need hard-to-find parts at premium prices.</p>
      </div>
      <div class="card card-outline">
        <h3>Shop type & overhead</h3>
        <p class="muted">Dealerships have higher overhead and charge more. National chains (Firestone, Midas) fall mid-range. Independent mechanics often offer best value but vary in quality.</p>
      </div>
      <div class="card card-outline">
        <h3>Diagnostic complexity</h3>
        <p class="muted">Simple issues take 30-60 minutes to diagnose. Complex electrical or engine problems require 2-3 hours. Many shops credit diagnostic fees toward repairs.</p>
      </div>
      <div class="card card-outline">
        <h3>Geographic location</h3>
        <p class="muted">Urban markets and high cost-of-living areas charge 15-30% more. Rural independent shops often offer better rates than city dealerships.</p>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container narrow">
    <h2 style="text-align: center; margin-bottom: 32px;">Car repair cost breakdown by service type</h2>
    
    <div class="card" style="margin-bottom: 24px;">
      <h3>Brake service</h3>
      <p><strong>Average cost:</strong> $150–$600 per axle</p>
      <p class="muted">Pads alone: $150-$350. Pads + rotors: $300-$600. Calipers add $150-$300 per side. Rear brakes typically cost less than front due to less wear.</p>
      <p class="muted"><strong>Fair price indicators:</strong> Labor time (1-2 hours per axle), parts brand (Brembo, Wagner, Raybestos), whether hardware/clips included, and brake fluid flush recommended.</p>
    </div>

    <div class="card" style="margin-bottom: 24px;">
      <h3>Routine maintenance</h3>
      <p><strong>Average cost:</strong> $40–$300</p>
      <p class="muted">Oil change: $40-$100. Tire rotation: $35-$75. Air filter: $20-$60. Spark plugs: $100-$300. Follow owner's manual intervals—not shop recommendations.</p>
      <p class="muted"><strong>Fair price indicators:</strong> Oil type/weight specified, filter quality mentioned, whether inspection or fluid top-offs are included, and mileage-based service schedules.</p>
    </div>

    <div class="card" style="margin-bottom: 24px;">
      <h3>Battery, starter, alternator</h3>
      <p><strong>Average cost:</strong> $100–$800</p>
      <p class="muted">Battery: $100-$250. Starter: $300-$600. Alternator: $400-$800. Many auto parts stores test these free—verify diagnosis before paying for replacement.</p>
      <p class="muted"><strong>Fair price indicators:</strong> Battery CCA rating, part numbers for starter/alternator, core charge refunds, warranty length (1-3 years typical), and testing results shown.</p>
    </div>

    <div class="card" style="margin-bottom: 24px;">
      <h3>Suspension & steering</h3>
      <p><strong>Average cost:</strong> $300–$1,200</p>
      <p class="muted">Struts/shocks: $400-$900 per pair. Control arms: $300-$600 per side. Ball joints: $200-$500 per side. Alignment: $75-$150 (often needed after work).</p>
      <p class="muted"><strong>Fair price indicators:</strong> Part brand (Monroe, KYB, Moog), whether alignment is included or separate, labor hours, and if bushings/mounts are itemized.</p>
    </div>

    <div class="card" style="margin-bottom: 24px;">
      <h3>Transmission service</h3>
      <p><strong>Average cost:</strong> $150–$400</p>
      <p class="muted">Fluid change: $150-$250. Filter replacement: $200-$400. Full transmission rebuild/replacement runs $1,800-$3,500+. Confirm diagnosis with multiple shops for major work.</p>
      <p class="muted"><strong>Fair price indicators:</strong> Quarts of fluid needed, filter brand, pan gasket replacement, and whether tech checked for metal shavings indicating internal damage.</p>
    </div>

    <div class="card" style="margin-bottom: 24px;">
      <h3>Engine repairs</h3>
      <p><strong>Average cost:</strong> $500–$5,000+</p>
      <p class="muted">Timing belt: $500-$1,200. Head gasket: $1,200-$2,500. Engine rebuild: $2,500-$5,000. Replacement: $2,000-$7,000. Get second opinions for major engine work.</p>
      <p class="muted"><strong>Fair price indicators:</strong> Diagnostic test results (compression, leak-down), labor hours (head gaskets take 8-15 hours), parts itemized, and warranty terms.</p>
    </div>
  </div>
</section>

<section class="section section-tight" style="background: var(--bg-2);">
  <div class="container">
    <h2 style="text-align: center; margin-bottom: 40px;">How to save money on car repairs</h2>
    <div class="grid-2">
      <div class="card">
        <h3>Get multiple quotes</h3>
        <p class="muted">For repairs over $500, get 2-3 estimates. Compare labor rates, part brands, and warranties. Avoid both suspiciously low bids and excessive high quotes.</p>
      </div>
      <div class="card">
        <h3>Ask about aftermarket parts</h3>
        <p class="muted">OEM parts cost significantly more. Quality aftermarket brands perform identically with warranties. Don't pay OEM premiums unless warranty requires it.</p>
      </div>
      <div class="card">
        <h3>Decline unnecessary upsells</h3>
        <p class="muted">Shops push flushes, fuel additives, and "preventive" services. Follow your owner's manual schedule only—not shop recommendations designed to maximize revenue.</p>
      </div>
      <div class="card">
        <h3>DIY simple repairs</h3>
        <p class="muted">Air filters, cabin filters, wiper blades, and batteries are easy DIY fixes. YouTube has model-specific tutorials. Save $50-$150 per service.</p>
      </div>
      <div class="card">
        <h3>Buy used or rebuilt parts</h3>
        <p class="muted">Salvage yards sell tested starters, alternators, transmissions at 40-70% off. Most have 30-90 day warranties. Great option for older vehicles.</p>
      </div>
      <div class="card">
        <h3>Check warranty coverage first</h3>
        <p class="muted">New car warranties cover powertrain 5+ years. Extended warranties may cover expensive repairs. Verify coverage before paying out-of-pocket.</p>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container narrow">
    <h2 style="text-align: center; margin-bottom: 32px;">Common car repair estimate questions</h2>
    
    <div class="card" style="margin-bottom: 20px;">
      <h3>Should I go to the dealership or independent mechanic?</h3>
      <p class="muted">Dealerships charge 20-40% more but have specialized tools and OEM parts. Independent mechanics offer better value for out-of-warranty cars. Look for ASE-certified shops.</p>
    </div>

    <div class="card" style="margin-bottom: 20px;">
      <h3>How do I know the diagnosis is accurate?</h3>
      <p class="muted">Ask to see failed parts or diagnostic scan results. Get second opinions for expensive repairs ($1,000+). Reputable shops explain findings and show evidence.</p>
    </div>

    <div class="card" style="margin-bottom: 20px;">
      <h3>What warranty should I expect on repairs?</h3>
      <p class="muted">Parts typically carry 1-3 year warranties. Labor warranties run 30-90 days minimum. Nationwide chains often offer longer coverage. Get warranty terms in writing.</p>
    </div>

    <div class="card" style="margin-bottom: 20px;">
      <h3>Can I bring my own parts to save money?</h3>
      <p class="muted">Some shops allow customer-supplied parts but won't warranty them. Others refuse due to liability. Ask upfront—shops may match online pricing to keep the business.</p>
    </div>

    <div class="card" style="margin-bottom: 20px;">
      <h3>When is repair not worth it?</h3>
      <p class="muted">If repair exceeds 50% of vehicle value, or multiple expensive repairs loom (transmission + engine), replacement is often smarter. Consider age, mileage, overall condition.</p>
    </div>

    <div class="card" style="margin-bottom: 20px;">
      <h3>How do I avoid getting upsold?</h3>
      <p class="muted">Request written estimates before approving extra work. Decline services not in your manual or due within 6 months. Ask "what happens if I wait?"</p>
    </div>
  </div>
</section>

<section class="section section-tight">
  <div class="container">
    <div class="section-header compact-center">
      <h2>How to know if your car repair estimate is fair</h2>
      <p>Upload your estimate and get a clear verdict in under a minute.</p>
    </div>
    <div class="grid-3">
      <div class="card card-outline">
        <h3>Upload the quote</h3>
        <p class="muted">Drop in a PDF, photo, or screenshot of your car repair estimate.</p>
      </div>
      <div class="card card-outline">
        <h3>See the likely fair range</h3>
        <p class="muted">Get instant feedback on whether the price looks normal, high, or inflated.</p>
      </div>
      <div class="card card-outline">
        <h3>Ask better questions</h3>
        <p class="muted">Use our suggested follow-up questions to push back before you approve anything.</p>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container narrow">
    <div class="card-soft">
      <h2>Stop guessing. Start saving.</h2>
      <p>Car repair estimates can hide labor padding, inflated parts pricing, and unnecessary services. Our tool gives you the pricing insight you need to negotiate confidently.</p>
      <div class="hero-actions" style="justify-content: center; margin-top: 20px;">
        <a href="/upload" class="btn">Check your car repair estimate now</a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__.'/partials/footer.php'; ?>
