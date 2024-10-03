<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orrery Level 1 - The Sun</title>
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
    <h1>The Sun</h1>
    <p>Click on the Sun to learn more about it!</p>
  </div>
  <button id="next-button" style="display: none;">Proceed to Level 2</button>

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

    camera.position.z = 15;

    // OrbitControls (Fix applied)
    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableZoom = true;

    // Animation loop
    function animate() {
      requestAnimationFrame(animate);

      // Rotate the Sun
      sun.rotation.y += 0.005;  // Adjust the speed as needed (higher = faster)

      renderer.render(scene, camera);
    }
    animate();

    // Interaction: Click to show Sun information
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
      const intersects = raycaster.intersectObject(sun);

      if (intersects.length > 0) {
        // Update info panel with facts about the Sun
        infoPanel.innerHTML = `
          <h1>The Sun</h1>
          <p><strong>Diameter:</strong> 1.39 million kilometers</p>
          <p><strong>Composition:</strong> 74% hydrogen, 24% helium</p>
          <p><strong>Surface Temperature:</strong> 5,500°C</p>
          <p><strong>Fun Fact:</strong> The Sun makes up 99.8% of the solar system’s mass!</p>
        `;
        // Show the "Next" button
        nextButton.style.display = 'block';
      }
    });

    // Proceed to next level (placeholder)
    nextButton.addEventListener('click', () => {
      alert('Proceeding to Level 2!');
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
