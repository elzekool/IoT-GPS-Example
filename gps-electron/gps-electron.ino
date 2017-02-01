#include <TinyGPS++.h>

TinyGPSPlus gps;
FuelGauge fuel;

int cloudHasFix;
double cloudLat;
double cloudLng;
int cloudSatelites;
double cloudBatVoltage;

void setup() {
    Serial1.begin(38400);

    Particle.variable("hasFix", cloudHasFix);
    Particle.variable("lat", cloudLat);
    Particle.variable("lng", cloudLng);
    Particle.variable("satelites", cloudSatelites);
    Particle.variable("batVoltage", cloudBatVoltage);
}

void loop() {

    while (Serial1.available() > 0) {
        gps.encode(Serial1.read());
    }

    cloudHasFix = gps.location.isValid() ? 1 : 0;
    cloudLat = gps.location.isValid() ? gps.location.lat() : 0;
    cloudLng = gps.location.isValid() ? gps.location.lng() : 0;
    cloudSatelites = gps.location.isValid() ? gps.satellites.value() : 0;

    cloudBatVoltage = fuel.getVCell();
}


