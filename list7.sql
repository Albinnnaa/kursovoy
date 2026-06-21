-- Триггер для проверки занятого времени
CREATE TRIGGER check_appointment_before_insert
BEFORE INSERT ON appointments
BEGIN
    SELECT CASE
        WHEN EXISTS (
            SELECT 1 FROM appointments 
            WHERE master_id = NEW.master_id 
            AND appointment_date = NEW.appointment_date 
            AND appointment_time = NEW.appointment_time
            AND status != 'cancelled'
        ) THEN RAISE(ABORT, 'Это время уже занято')
    END;
END;

-- Триггер для обновления updated_at
CREATE TRIGGER update_appointments_timestamp
AFTER UPDATE ON appointments
BEGIN
    UPDATE appointments SET updated_at = CURRENT_TIMESTAMP 
    WHERE id = NEW.id;
END;

-- Триггер для логирования изменений статуса
CREATE TRIGGER log_appointment_status_change
AFTER UPDATE OF status ON appointments
BEGIN
    INSERT INTO appointment_logs (appointment_id, old_status, new_status, changed_at)
    VALUES (OLD.id, OLD.status, NEW.status, CURRENT_TIMESTAMP);
END;