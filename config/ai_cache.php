<?php
/**
 * Sistema de caché para respuestas de IA
 * Evita gastar tokens repitiendo la misma consulta
 */

require_once __DIR__ . '/database.php';

/**
 * Busca en caché. Devuelve el array decodificado o null si no existe.
 */
function getAICache($cacheKey) {
    try {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT response, id FROM ai_cache
            WHERE cache_key = ? AND expires_at > NOW()
            LIMIT 1
        ");
        $stmt->execute([$cacheKey]);
        $row = $stmt->fetch();

        if ($row) {
            // Incrementar contador de hits
            $db->prepare("UPDATE ai_cache SET hits = hits + 1 WHERE id = ?")
               ->execute([$row['id']]);
            return json_decode($row['response'], true);
        }
        return null;
    } catch (Exception $e) {
        error_log("[AI Cache] Error leyendo: " . $e->getMessage());
        return null;
    }
}

/**
 * Guarda una respuesta en caché
 */
function setAICache($cacheKey, $response, $model = '', $ttlHours = 24) {
    try {
        $db = getDB();
        $expiresAt = date('Y-m-d H:i:s', strtotime("+{$ttlHours} hours"));

        $db->prepare("
            INSERT INTO ai_cache (cache_key, prompt_hash, response, model, expires_at)
            VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
                response = VALUES(response),
                model = VALUES(model),
                expires_at = VALUES(expires_at),
                created_at = CURRENT_TIMESTAMP
        ")->execute([
            $cacheKey,
            hash('sha256', $cacheKey),
            json_encode($response),
            $model,
            $expiresAt
        ]);
        return true;
    } catch (Exception $e) {
        error_log("[AI Cache] Error guardando: " . $e->getMessage());
        return false;
    }
}

/**
 * Limpia entradas expiradas (llamar de vez en cuando)
 */
function cleanExpiredAICache() {
    try {
        $db = getDB();
        return $db->exec("DELETE FROM ai_cache WHERE expires_at < NOW()");
    } catch (Exception $e) {
        return 0;
    }
}

/**
 * Estadísticas del caché (para dashboard)
 */
function getAICacheStats() {
    try {
        $db = getDB();
        $stats = $db->query("
            SELECT
                COUNT(*) as total_entries,
                COALESCE(SUM(hits), 0) as total_hits,
                COALESCE(AVG(hits), 0) as avg_hits,
                MAX(created_at) as last_created
            FROM ai_cache
            WHERE expires_at > NOW()
        ")->fetch();
        return $stats;
    } catch (Exception $e) {
        return null;
    }
}