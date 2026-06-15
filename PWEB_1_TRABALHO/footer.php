<?php
?>
<style>

    html, body {
        height: 100%;
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    main, .corpo, article {
        flex: 1 0 auto;
    }

    footer {
        flex-shrink: 0;
    }
</style>

<footer style="background-color: #2a0810; color: #D4A35D; text-align: center; padding: 20px 0; font-family: sans-serif; width: 100%;">
    <div class="container">
        <p style="margin: 0; font-size: 14px; font-weight: 500;">
            &copy; <?php echo date('Y'); ?> Café Grão de Ouro. .
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>