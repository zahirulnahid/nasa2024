<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orrery Level 3 - Venus</title>
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
    <h1>Venus</h1>
    <p>Click on Venus to learn more about it!</p>
  </div>
  <button id="next-button" style="display: none;">Proceed to Level 4</button>

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

    // Create Mercury
    const mercuryGeometry = new THREE.SphereGeometry(0.5, 32, 32);
    const mercuryMaterial = new THREE.MeshBasicMaterial({ color: 0xaaaaaa });
    const mercury = new THREE.Mesh(mercuryGeometry, mercuryMaterial);
    
    const mercuryOrbitRadius = 10;
    mercury.position.x = mercuryOrbitRadius;
    scene.add(mercury);

    // Create Venus
    const venusGeometry = new THREE.SphereGeometry(0.6, 32, 32);
    // Use a standard material to ensure raycasting works
    const venusMaterial = new THREE.MeshStandardMaterial({ color: 0xffcc66 });
    const venus = new THREE.Mesh(venusGeometry, venusMaterial);
    
    const venusOrbitRadius = 15;
    venus.position.x = venusOrbitRadius;
    scene.add(venus);

    // Add lighting to interact with MeshStandardMaterial
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
    scene.add(ambientLight);
    const pointLight = new THREE.PointLight(0xffffff, 1);
    scene.add(pointLight);

    // OrbitControls
    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableZoom = true;

    camera.position.z = 25;

    // Animation loop (make Mercury and Venus orbit around the Sun)
    let mercuryAngle = 0;
    let venusAngle = 0;

    function animate() {
      requestAnimationFrame(animate);

      // Rotate the Sun
      sun.rotation.y += 0.005;

      // Mercury orbit
      mercuryAngle += 0.02; // Faster orbit for Mercury
      mercury.position.x = mercuryOrbitRadius * Math.cos(mercuryAngle);
      mercury.position.z = mercuryOrbitRadius * Math.sin(mercuryAngle);

      // Venus orbit
      venusAngle += 0.015; // Slower orbit for Venus
      venus.position.x = venusOrbitRadius * Math.cos(venusAngle);
      venus.position.z = venusOrbitRadius * Math.sin(venusAngle);

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

      // Detect click on Mercury or Venus
      const intersects = raycaster.intersectObjects([mercury, venus]);
      
      if (intersects.length > 0) {
        const clickedObject = intersects[0].object;

        if (clickedObject === mercury) {
          // Update info panel with facts about Mercury
          infoPanel.innerHTML = `
            <h1>Mercury</h1>
            <p><strong>Diameter:</strong> 4,880 kilometers</p>
            <p><strong>Orbit Time:</strong> 88 Earth days</p>
            <p><strong>Surface Temperature:</strong> -173 to 427°C</p>
            <p><strong>Fun Fact:</strong> Mercury is the smallest planet in our solar system!</p>
          `;
        } else if (clickedObject === venus) {
          // Update info panel with facts about Venus
          infoPanel.innerHTML = `
            <h1>Venus</h1>
            <p><strong>Diameter:</strong> 12,104 kilometers</p>
            <p><strong>Orbit Time:</strong> 225 Earth days</p>
            <p><strong>Surface Temperature:</strong> 465°C</p>
            <p><strong>Fun Fact:</strong> Venus is the hottest planet in the solar system!</p>
          `;
        }

        // Show the "Next" button
        nextButton.style.display = 'block';
      }
    });

    // Proceed to next level
    nextButton.addEventListener('click', () => {
      alert('Proceeding to Level 4!');
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
