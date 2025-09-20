import face_recognition
import sys
import os
import json

def recognize_face(image_path, known_faces_dir):
    unknown_image = face_recognition.load_image_file(image_path)
    unknown_encodings = face_recognition.face_encodings(unknown_image)

    if len(unknown_encodings) == 0:
        return {"status": "fail", "message": "No face found in image"}

    results = []
    for file_name in os.listdir(known_faces_dir):
        if not file_name.endswith((".jpg", ".png")):
            continue

        known_image = face_recognition.load_image_file(os.path.join(known_faces_dir, file_name))
        known_encodings = face_recognition.face_encodings(known_image)
        if len(known_encodings) == 0:
            continue

        match = face_recognition.compare_faces([known_encodings[0]], unknown_encodings[0])[0]
        if match:
            results.append(file_name.split(".")[0])

    if len(results) > 0:
        return {"status": "success", "recognized": results}
    else:
        return {"status": "fail", "message": "Face not recognized"}

if __name__ == "__main__":
    image_path = sys.argv[1]
    known_faces_dir = sys.argv[2]
    result = recognize_face(image_path, known_faces_dir)
    print(json.dumps(result))
