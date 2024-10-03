<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orrery Level 2 - Mercury</title>
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
    <h1>Mercury</h1>
    <p>Click on Mercury to learn more about it!</p>
  </div>
  <button id="next-button" style="display: none;">Proceed to Level 3</button>

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

    // Create the Sun (from Level 1)
    const sunGeometry = new THREE.SphereGeometry(5, 32, 32);
    const sunMaterial = new THREE.MeshBasicMaterial({ map: new THREE.TextureLoader().load('image/sun_texture.jpg') });
    const sun = new THREE.Mesh(sunGeometry, sunMaterial);
    scene.add(sun);

    // Create Mercury
    const mercuryGeometry = new THREE.SphereGeometry(1, 32, 32);
    const mercuryMaterial = new THREE.MeshBasicMaterial({ map: new THREE.TextureLoader().load('image/mercury_texture.jpg') });
    const mercury = new THREE.Mesh(mercuryGeometry, mercuryMaterial);

    // Create Mercury's orbit
    const mercuryOrbit = new THREE.Group();
    mercuryOrbit.add(mercury);
    scene.add(mercuryOrbit);

    camera.position.z = 20;

    // OrbitControls
    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableZoom = true;

    // Animation loop
    const mercuryOrbitRadius = 10; // Radius of Mercury's orbit
    let mercuryAngle = 0; // Starting angle for orbit

    function animate() {
      requestAnimationFrame(animate);

      // Rotate the Sun
      sun.rotation.y += 0.005;

      // Make Mercury orbit around the Sun
      mercuryAngle += 0.01;  // Speed of Mercury's orbit
      mercury.position.set(
        mercuryOrbitRadius * Math.cos(mercuryAngle),
        0,
        mercuryOrbitRadius * Math.sin(mercuryAngle)
      );

      renderer.render(scene, camera);
    }
    animate();

    // Interaction: Click to show Mercury information
    const infoPanel = document.getElementById('info-panel');
    const nextButton = document.getElementById('next-button');

    document.addEventListener('click', (event) => {
      // Raycaster to detect clicks
      const raycaster = new THREE.Raycaster();
      const mouse = new THREE.Vector2(
        (event.clientX / window.innerWidth) * 2 - 1,
        -(event.clientY / window.innerHeight) * 2 + 1
      );
      raycaster.setFromCamera(mouse, camera);
      const intersects = raycaster.intersectObject(mercury);

      if (intersects.length > 0) {
        // Update info panel with facts about Mercury
        infoPanel.innerHTML = `
          <h1>Mercury</h1>
          <p><strong>Diameter:</strong> 4,880 kilometers</p>
          <p><strong>Orbit:</strong> 88 Earth days</p>
          <p><strong>Surface Temperature:</strong> -173°C to 427°C</p>
          <p><strong>Fun Fact:</strong> Mercury has the most eccentric orbit of all the planets in the Solar System!</p>
        `;
        // Show the "Next" button
        nextButton.style.display = 'block';
      }
    });

    // Proceed to next level (placeholder)
    nextButton.addEventListener('click', () => {
      alert('Proceeding to Level 3!');
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
