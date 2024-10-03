<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orrery Level 9 - Neptune</title>
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
    <h1>Neptune</h1>
    <p>Click on Neptune to learn more about it!</p>
  </div>
  <button id="next-button" style="display: none;">Proceed to Level 10</button>

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

    // Create Earth, Moon, Mars, Jupiter, Saturn, and Uranus (from previous levels)
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
    moon.position.x = earthOrbitRadius + moonOrbitRadius;
    scene.add(moon);

    const marsGeometry = new THREE.SphereGeometry(0.5, 32, 32);
    const marsMaterial = new THREE.MeshStandardMaterial({ map: new THREE.TextureLoader().load('image/mars_texture.jpg') });
    const mars = new THREE.Mesh(marsGeometry, marsMaterial);
    
    const marsOrbitRadius = 30;
    mars.position.x = marsOrbitRadius;
    scene.add(mars);

    const jupiterGeometry = new THREE.SphereGeometry(1.5, 32, 32);
    const jupiterMaterial = new THREE.MeshStandardMaterial({ map: new THREE.TextureLoader().load('image/jupiter_texture.jpg') });
    const jupiter = new THREE.Mesh(jupiterGeometry, jupiterMaterial);
    
    const jupiterOrbitRadius = 40; // Jupiter orbit radius
    jupiter.position.x = jupiterOrbitRadius;
    scene.add(jupiter);

    const saturnGeometry = new THREE.SphereGeometry(1.2, 32, 32);
    const saturnMaterial = new THREE.MeshStandardMaterial({ map: new THREE.TextureLoader().load('image/saturn_texture.jpg') });
    const saturn = new THREE.Mesh(saturnGeometry, saturnMaterial);
    
    const saturnOrbitRadius = 50; // Saturn orbit radius
    saturn.position.x = saturnOrbitRadius;
    scene.add(saturn);

    // Create Uranus (from previous level)
    const uranusGeometry = new THREE.SphereGeometry(1.1, 32, 32);
    const uranusMaterial = new THREE.MeshStandardMaterial({ color: 0x00bfff }); // Light blue color for Uranus
    const uranus = new THREE.Mesh(uranusGeometry, uranusMaterial);
    
    const uranusOrbitRadius = 70; // Uranus orbit radius
    uranus.position.x = uranusOrbitRadius;
    scene.add(uranus);

    // Create Neptune
    const neptuneGeometry = new THREE.SphereGeometry(1.1, 32, 32);
    const neptuneMaterial = new THREE.MeshStandardMaterial({ color: 0x0000ff }); // Deep blue color for Neptune
    const neptune = new THREE.Mesh(neptuneGeometry, neptuneMaterial);
    
    const neptuneOrbitRadius = 90; // Neptune orbit radius
    neptune.position.x = neptuneOrbitRadius;
    scene.add(neptune);

    // Add lighting
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
    scene.add(ambientLight);
    const pointLight = new THREE.PointLight(0xffffff, 1);
    scene.add(pointLight);

    // OrbitControls
    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableZoom = true;

    camera.position.z = 100;

    // Animation loop (make all planets orbit the Sun)
    let earthAngle = 0;
    let moonAngle = 0;
    let marsAngle = 0;
    let jupiterAngle = 0;
    let saturnAngle = 0;
    let uranusAngle = 0;
    let neptuneAngle = 0;

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

      // Jupiter orbit
      jupiterAngle += 0.0025;
      jupiter.position.x = jupiterOrbitRadius * Math.cos(jupiterAngle);
      jupiter.position.z = jupiterOrbitRadius * Math.sin(jupiterAngle);

      // Saturn orbit
      saturnAngle += 0.0015;
      saturn.position.x = saturnOrbitRadius * Math.cos(saturnAngle);
      saturn.position.z = saturnOrbitRadius * Math.sin(saturnAngle);

      // Uranus orbit
      uranusAngle += 0.001;
      uranus.position.x = uranusOrbitRadius * Math.cos(uranusAngle);
      uranus.position.z = uranusOrbitRadius * Math.sin(uranusAngle);

      // Neptune orbit
      neptuneAngle += 0.0005;
      neptune.position.x = neptuneOrbitRadius * Math.cos(neptuneAngle);
      neptune.position.z = neptuneOrbitRadius * Math.sin(neptuneAngle);

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

      // Detect click on planets
      const intersects = raycaster.intersectObjects([sun, earth, moon, mars, jupiter, saturn, uranus, neptune]);

      if (intersects.length > 0) {
        const clickedObject = intersects[0].object;

        // Display information based on clicked object
        if (clickedObject === neptune) {
          infoPanel.innerHTML = `
            <h1>Neptune</h1>
            <p><strong>Diameter:</strong> 49,244 kilometers</p>
            <p><strong>Orbit Time:</strong> 165 Earth years</p>
            <p><strong>Surface Temperature:</strong> -214°C</p>
            <p><strong>Fun Fact:</strong> Neptune has the strongest winds in the solar system!</p>
          `;
          // Show the "Next" button
          nextButton.style.display = 'block';
        }
      }
    });

    // Proceed to next level
    nextButton.addEventListener('click', () => {
      // Redirect to the next level (Level 10)
      window.location.href = 'level10.html';
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
