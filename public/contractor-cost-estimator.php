<?php
$title = "Contractor Cost Estimator - Check If Your Quote Is Fair | Are They Screwing Me?";
$metaDescription = "Use our contractor cost estimator to review home improvement quotes. Check typical pricing for remodeling, repairs, and construction projects. Upload your contractor estimate to see if you're being overcharged.";
$metaKeywords = 'contractor cost estimator, home contractor pricing, remodeling cost calculator, construction estimate checker, contractor quote tool';
include __DIR__.'/partials/header.php';
?>
<section class="hero-simple">
  <div class="container">
    <span class="eyebrow">Contractor Cost Estimator</span>
    <h1>Estimate contractor costs before you commit</h1>
    <p class="lead">Our contractor cost estimator helps you understand what home improvement projects should cost—from kitchen remodels to deck builds. Upload your quote and see if the pricing is fair or inflated.</p>
    <div class="hero-actions">
      <a href="/upload?category=contractor" class="btn">Upload your contractor estimate</a>
      <a href="/signup" class="btn btn-outline">Get 2 free checks</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="quote-box" style="max-width: 900px; margin: 0 auto;">
      <div class="section-header" style="margin-bottom:18px">
        <h2>Typical contractor cost ranges by project</h2>
        <p>Contractor costs vary widely—from <strong>$1,000 to $50,000+</strong>—based on project scope, materials, and labor complexity.</p>
      </div>
      
      <h3 style="margin-bottom:12px">Common contractor projects & estimated costs</h3>
      <ul class="list">
        <li><strong>Bathroom remodel (basic):</strong> $6,000–$18,000</li>
        <li><strong>Kitchen remodel (mid-range):</strong> $12,000–$35,000</li>
        <li><strong>Deck construction:</strong> $4,000–$12,000</li>
        <li><strong>Basement finishing:</strong> $10,000–$30,000</li>
        <li><strong>Room addition:</strong> $25,000–$100,000+</li>
        <li><strong>Flooring installation:</strong> $2,000–$8,000</li>
        <li><strong>Painting (interior):</strong> $1,500–$5,000</li>
        <li><strong>Fence installation:</strong> $1,500–$6,000</li>
        <li><strong>Siding replacement:</strong> $5,000–$15,000</li>
      </ul>

      <div class="divider"></div>

      <h3 style="margin-bottom:12px">Is your contractor estimate too high?</h3>
      <p class="muted">Watch out for these red flags in contractor estimates:</p>
      <ul class="list">
        <li>Vague line items like "miscellaneous" or "contingency" without clear explanation</li>
        <li>No material specifications, brands, or quality levels listed</li>
        <li>Labor bundled into large lump sums with no hourly breakdown</li>
        <li>Large upfront deposits (50%+) before work begins</li>
        <li>Timeline missing or unrealistically vague ("a few weeks")</li>
      </ul>

      <div class="divider"></div>

      <div class="hero-actions" style="justify-content: flex-start; margin-top: 24px;">
        <a href="/upload?category=contractor" class="btn">Check if you're being overcharged</a>
      </div>
    </div>
  </div>
</section>

<section class="section section-tight">
  <div class="container">
    <div class="section-header compact-center">
      <h2>What affects contractor cost estimates?</h2>
      <p>Understanding these factors helps you evaluate whether your quote is reasonable.</p>
    </div>
    <div class="grid-3">
      <div class="card card-outline">
        <h3>Project scope & complexity</h3>
        <p class="muted">Structural work, permits, and multi-trade coordination cost more than cosmetic updates. Moving walls, electrical, or plumbing adds significant expense.</p>
      </div>
      <div class="card card-outline">
        <h3>Material quality tiers</h3>
        <p class="muted">Builder-grade materials cost 30-50% less than premium finishes. Mid-tier options balance cost and quality. Reserve splurges for high-visibility areas only.</p>
      </div>
      <div class="card card-outline">
        <h3>Labor rates & subcontractors</h3>
        <p class="muted">General contractors mark up subcontractor labor 15-30% for coordination. Licensed specialists (electricians, plumbers) cost $80-$150/hour vs. general labor at $50-$80/hour.</p>
      </div>
      <div class="card card-outline">
        <h3>Location & accessibility</h3>
        <p class="muted">Urban projects cost 10-25% more due to parking limitations, noise restrictions, and limited staging areas. Upper floors or tight spaces increase labor time.</p>
      </div>
      <div class="card card-outline">
        <h3>Permits & inspections</h3>
        <p class="muted">Major projects require $500-$2,000 in permits. Inspections add scheduling delays and potential rework costs if work doesn't meet code requirements.</p>
      </div>
      <div class="card card-outline">
        <h3>Contractor reputation & demand</h3>
        <p class="muted">Established contractors with strong portfolios charge 15-30% premiums. High-demand seasons (spring/summer) command higher pricing than off-season work.</p>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container narrow">
    <h2 style="text-align: center; margin-bottom: 32px;">Contractor cost breakdown by project type</h2>
    
    <div class="card" style="margin-bottom: 24px;">
      <h3>Bathroom remodel</h3>
      <p><strong>Average cost:</strong> $6,000–$18,000</p>
      <p class="muted">Basic refresh (fixtures, tile, paint): $6,000-$10,000. Full gut-and-rebuild with moved plumbing: $12,000-$25,000. Luxury finishes add 30-50% more.</p>
      <p class="muted"><strong>Fair price indicators:</strong> Itemized fixtures (toilet, vanity, shower), tile square footage, labor hours per trade (plumbing, electrical, tile), demo/disposal costs.</p>
    </div>

    <div class="card" style="margin-bottom: 24px;">
      <h3>Kitchen remodel</h3>
      <p><strong>Average cost:</strong> $12,000–$35,000</p>
      <p class="muted">Cabinet refacing + countertops: $12,000-$20,000. Full remodel with new cabinets, appliances, layout changes: $25,000-$50,000+. Island additions increase costs.</p>
      <p class="muted"><strong>Fair price indicators:</strong> Cabinet brand and linear feet, countertop material/square footage, appliance allowances specified, electrical/plumbing scope clearly defined.</p>
    </div>

    <div class="card" style="margin-bottom: 24px;">
      <h3>Deck construction</h3>
      <p><strong>Average cost:</strong> $4,000–$12,000</p>
      <p class="muted">Pressure-treated wood decks: $15-$30 per sq ft. Composite decks: $30-$45 per sq ft. Railings, stairs, built-in seating, and pergolas add $1,000-$5,000.</p>
      <p class="muted"><strong>Fair price indicators:</strong> Square footage, material type (cedar, composite brand), post/beam specs, footing depth, permit fees included or separate.</p>
    </div>

    <div class="card" style="margin-bottom: 24px;">
      <h3>Basement finishing</h3>
      <p><strong>Average cost:</strong> $10,000–$30,000</p>
      <p class="muted">Basic finish (drywall, flooring, lighting): $25-$50 per sq ft. Adding full bathroom, wet bar, or egress windows increases costs 30-50%.</p>
      <p class="muted"><strong>Fair price indicators:</strong> Square footage, ceiling height, HVAC extension requirements, electrical/plumbing rough-in costs, waterproofing if needed.</p>
    </div>

    <div class="card" style="margin-bottom: 24px;">
      <h3>Room addition</h3>
      <p><strong>Average cost:</strong> $25,000–$100,000+</p>
      <p class="muted">Bump-outs (50-150 sq ft): $25,000-$50,000. Full room additions (200-400 sq ft): $80-$200 per sq ft depending on foundation type and finish level.</p>
      <p class="muted"><strong>Fair price indicators:</strong> Foundation type (slab vs. crawl space), wall tie-in complexity, roof integration, HVAC/electrical capacity upgrades needed.</p>
    </div>

    <div class="card" style="margin-bottom: 24px;">
      <h3>Flooring installation</h3>
      <p><strong>Average cost:</strong> $2,000–$8,000</p>
      <p class="muted">Vinyl plank/laminate: $3-$8 per sq ft installed. Hardwood: $8-$15 per sq ft. Tile: $10-$20 per sq ft with prep and waterproofing.</p>
      <p class="muted"><strong>Fair price indicators:</strong> Square footage, material brand/quality tier, subfloor prep requirements, transition strips, furniture moving included or extra.</p>
    </div>
  </div>
</section>

<section class="section section-tight" style="background: var(--bg-2);">
  <div class="container">
    <h2 style="text-align: center; margin-bottom: 40px;">How to save money on contractor projects</h2>
    <div class="grid-2">
      <div class="card">
        <h3>Get 3-5 detailed estimates</h3>
        <p class="muted">Request itemized quotes from multiple contractors. Compare line-by-line to identify where pricing diverges—materials, labor, overhead, or profit margins.</p>
      </div>
      <div class="card">
        <h3>Supply your own materials</h3>
        <p class="muted">Contractors mark up materials 20-40%. Buying fixtures, tile, or lumber yourself saves thousands—but verify return policies and measurements first.</p>
      </div>
      <div class="card">
        <h3>Do your own demo work</h3>
        <p class="muted">Demolition labor costs $50-$100/hour. Removing cabinets, flooring, or drywall yourself saves $500-$2,000 on smaller projects.</p>
      </div>
      <div class="card">
        <h3>Schedule during off-season</h3>
        <p class="muted">Book in late fall or winter when demand drops. Contractors offer 10-20% discounts to keep crews busy during traditionally slow months.</p>
      </div>
      <div class="card">
        <h3>Choose mid-tier finishes</h3>
        <p class="muted">Premium materials cost 2-3x more but often look nearly identical to mid-range options. Reserve upgrades for countertops or fixtures only—not behind-wall components.</p>
      </div>
      <div class="card">
        <h3>Negotiate payment terms</h3>
        <p class="muted">Avoid large upfront deposits. Standard terms: 10% to start, 40% at midpoint, 50% on completion. Never pay in full before work is finished.</p>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container narrow">
    <h2 style="text-align: center; margin-bottom: 32px;">Common contractor cost estimator questions</h2>
    
    <div class="card" style="margin-bottom: 20px;">
      <h3>How detailed should contractor estimates be?</h3>
      <p class="muted">Should include materials (brands/specs), labor hours or costs per trade, permits/fees, project timeline, payment schedule, warranty details. Avoid vague lump sums.</p>
    </div>

    <div class="card" style="margin-bottom: 20px;">
      <h3>What's a reasonable contractor deposit?</h3>
      <p class="muted">10-15% to secure scheduling is normal. Anything over 25% upfront is a red flag. Never pay 50%+ before work starts—that's a common scam pattern.</p>
    </div>

    <div class="card" style="margin-bottom: 20px;">
      <h3>Should I always choose the lowest bid?</h3>
      <p class="muted">Not necessarily. Lowest bids may use cheaper materials, cut corners, or underestimate scope (leading to change orders). Compare middle-range quotes for best value.</p>
    </div>

    <div class="card" style="margin-bottom: 20px;">
      <h3>How do I verify contractor credentials?</h3>
      <p class="muted">Check license status with state licensing board. Verify insurance (general liability + workers comp). Request references and check online reviews across multiple platforms.</p>
    </div>

    <div class="card" style="margin-bottom: 20px;">
      <h3>What if the project goes over budget?</h3>
      <p class="muted">Contracts should define how change orders work. Get pricing in writing before approving extras. Legitimate overruns (hidden damage) are normal; vague "unexpected costs" are not.</p>
    </div>

    <div class="card" style="margin-bottom: 20px;">
      <h3>How long should typical projects take?</h3>
      <p class="muted">Bathroom: 2-4 weeks. Kitchen: 4-8 weeks. Basement finish: 4-8 weeks. Room addition: 3-6 months. Factor in permit delays, inspections, material delivery times.</p>
    </div>
  </div>
</section>

<section class="section section-tight">
  <div class="container">
    <div class="section-header compact-center">
      <h2>How our contractor cost estimator works</h2>
      <p>Upload your estimate and get instant feedback in under a minute.</p>
    </div>
    <div class="grid-3">
      <div class="card card-outline">
        <h3>Upload the estimate</h3>
        <p class="muted">Drop in a PDF, photo, or screenshot of your contractor estimate or quote.</p>
      </div>
      <div class="card card-outline">
        <h3>See the likely fair range</h3>
        <p class="muted">Get instant feedback on whether the price looks normal, high, or inflated for your project.</p>
      </div>
      <div class="card card-outline">
        <h3>Ask better questions</h3>
        <p class="muted">Use our suggested follow-up questions to push back before you sign anything.</p>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container narrow">
    <div class="card-soft">
      <h2>Stop overpaying for home projects</h2>
      <p>Contractor estimates can hide unnecessary markups, vague pricing, and inflated labor. Our cost estimator gives you the pricing insight you need to negotiate confidently.</p>
      <div class="hero-actions" style="justify-content: center; margin-top: 20px;">
        <a href="/upload" class="btn">Estimate your contractor costs now</a>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__.'/partials/footer.php'; ?>
