<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orrery Level 5 - Mars</title>
  <style>
    body { margin: 0; overflow: hidden; }
    canvas { display: block; }
    #info-panel {
      position: absolute;
      top: 10px;
      left: 10px;
      background: rgba(0, 0, 0, 0.6);
      color: white;
      padding: 10px;
      font-family: Arial, sans-serif;
    }
    #next-button {
      position: absolute;
      bottom: 20px;
      right: 20px;
      padding: 10px 20px;
      background: #28a745;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 18px;
    }
    #next-button:hover {
      background: #218838;
    }
  </style>
</head>
<body>
  <div id="info-panel">
    <h1>Mars</h1>
    <p>Click on Mars to learn more about it!</p>
  </div>
  <button id="next-button" style="display: none;">Proceed to Level 6</button>

  <!-- Include Three.js and OrbitControls -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

  <script>
    // Set up scene, camera, and renderer
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer();
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.body.appendChild(renderer.domElement);

    // Add background (space)
    const spaceTexture = new THREE.TextureLoader().load('image/space.jpg');
    scene.background = spaceTexture;

    // Create the Sun
    const sunGeometry = new THREE.SphereGeometry(5, 32, 32);
    const sunMaterial = new THREE.MeshBasicMaterial({ map: new THREE.TextureLoader().load('image/sun_texture.jpg') });
    const sun = new THREE.Mesh(sunGeometry, sunMaterial);
    scene.add(sun);

    // Create Earth and Moon (from previous level)
    const earthGeometry = new THREE.SphereGeometry(0.7, 32, 32);
    const earthMaterial = new THREE.MeshStandardMaterial({ map: new THREE.TextureLoader().load('image/earth_texture.jpg') });
    const earth = new THREE.Mesh(earthGeometry, earthMaterial);
    
    const earthOrbitRadius = 20;
    earth.position.x = earthOrbitRadius;
    scene.add(earth);

    const moonGeometry = new THREE.SphereGeometry(0.2, 32, 32);
    const moonMaterial = new THREE.MeshBasicMaterial({ color: 0xaaaaaa });
    const moon = new THREE.Mesh(moonGeometry, moonMaterial);
    
    const moonOrbitRadius = 2;
    moon.position.x = earthOrbitRadius + moonOrbitRadius; // Position the moon near Earth
    scene.add(moon);

    // Create Mars
    const marsGeometry = new THREE.SphereGeometry(0.5, 32, 32);
    const marsMaterial = new THREE.MeshStandardMaterial({ map: new THREE.TextureLoader().load('image/mars_texture.jpg') });
    const mars = new THREE.Mesh(marsGeometry, marsMaterial);
    
    const marsOrbitRadius = 30; // Mars orbit radius
    mars.position.x = marsOrbitRadius; // Start Mars at its orbit radius
    scene.add(mars);

    // Add lighting
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
    scene.add(ambientLight);
    const pointLight = new THREE.PointLight(0xffffff, 1);
    scene.add(pointLight);

    // OrbitControls
    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableZoom = true;

    camera.position.z = 40;

    // Animation loop (make Earth and Mars orbit the Sun and Moon orbit the Earth)
    let earthAngle = 0;
    let moonAngle = 0;
    let marsAngle = 0;

    function animate() {
      requestAnimationFrame(animate);

      // Rotate the Sun
      sun.rotation.y += 0.005;

      // Earth orbit
      earthAngle += 0.01;
      earth.position.x = earthOrbitRadius * Math.cos(earthAngle);
      earth.position.z = earthOrbitRadius * Math.sin(earthAngle);

      // Moon orbit around Earth
      moonAngle += 0.05;
      moon.position.x = earth.position.x + moonOrbitRadius * Math.cos(moonAngle);
      moon.position.z = earth.position.z + moonOrbitRadius * Math.sin(moonAngle);

      // Mars orbit
      marsAngle += 0.005;
      mars.position.x = marsOrbitRadius * Math.cos(marsAngle);
      mars.position.z = marsOrbitRadius * Math.sin(marsAngle);

      renderer.render(scene, camera);
    }
    animate();

    // Raycaster for interaction
    const infoPanel = document.getElementById('info-panel');
    const nextButton = document.getElementById('next-button');

    document.addEventListener('click', (event) => {
      const raycaster = new THREE.Raycaster();
      const mouse = new THREE.Vector2(
        (event.clientX / window.innerWidth) * 2 - 1,
        -(event.clientY / window.innerHeight) * 2 + 1
      );
      raycaster.setFromCamera(mouse, camera);

      // Detect click on Earth, Moon, or Mars
      const intersects = raycaster.intersectObjects([earth, moon, mars]);
      
      if (intersects.length > 0) {
        const clickedObject = intersects[0].object;

        if (clickedObject === earth) {
          // Update info panel with facts about Earth
          infoPanel.innerHTML = `
            <h1>Earth</h1>
            <p><strong>Diameter:</strong> 12,742 kilometers</p>
            <p><strong>Orbit Time:</strong> 365.25 Earth days</p>
            <p><strong>Surface Temperature:</strong> -88 to 58°C</p>
            <p><strong>Fun Fact:</strong> Earth is the only planet known to support life!</p>
          `;
        } else if (clickedObject === moon) {
          // Update info panel with facts about the Moon
          infoPanel.innerHTML = `
            <h1>The Moon</h1>
            <p><strong>Diameter:</strong> 3,474 kilometers</p>
            <p><strong>Orbit Time:</strong> 27.3 Earth days</p>
            <p><strong>Surface Temperature:</strong> -173 to 127°C</p>
            <p><strong>Fun Fact:</strong> The Moon always shows the same face to Earth!</p>
          `;
        } else if (clickedObject === mars) {
          // Update info panel with facts about Mars
          infoPanel.innerHTML = `
            <h1>Mars</h1>
            <p><strong>Diameter:</strong> 6,779 kilometers</p>
            <p><strong>Orbit Time:</strong> 687 Earth days</p>
            <p><strong>Surface Temperature:</strong> -125 to 20°C</p>
            <p><strong>Fun Fact:</strong> Mars has the largest volcano in the solar system, Olympus Mons!</p>
          `;
        }

        // Show the "Next" button
        nextButton.style.display = 'block';
      }
    });

    // Proceed to next level
    nextButton.addEventListener('click', () => {
      alert('Proceeding to Level 6!');
    });

    // Adjust canvas on window resize
    window.addEventListener('resize', () => {
      camera.aspect = window.innerWidth / window.innerHeight;
      camera.updateProjectionMatrix();
      renderer.setSize(window.innerWidth, window.innerHeight);
    });
  </script>
</body>
</html>
