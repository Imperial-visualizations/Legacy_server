/** *******************************************************************************************************************
 *  Created to handle all the physics of the simulation using vecops.js
 * - Akash Bhattacharya & Robert King.
 ******************************************************************************************************************* **/

/**
 * Checks if n is a number or not.
 * @param n: Input
 * @returns {boolean}
 */
var isNumber = function (n) {
    return isFinite(n) && +n === n;
};

/**
 * Lennard-Jones potential class. If sigma2 and epsilon2 not provided, assuming atom 1 and atom 2 are identical.
 * @param sigma: Separation where potential is 0 for a1-a1 diatom.
 * @param epsilon: Potential at equilibrium distance for a1-a1 diatom.
 * @param sigma2: LJ param sigma for a2-a2 diatom.
 * @param epsilon2: Lj param epsilon for a2-a2 diatom.
 * @constructor
 */
LJ = function (sigma, epsilon, sigma2, epsilon2) {

    // Sanity check.
    if (!isNumber(sigma) || !isNumber(epsilon)) {
        console.error("Error! Sigma and Epsilon values invalid!");
    }
    // LJ parameters initialisation for Atom 1.
    var s1 = sigma;
    var e1 = epsilon;

    // LJ parameters initialisation for Atom 2.
    var s2, e2;
    // Heterogeneous diatomic molecule.
    if (isNumber(sigma2) && isNumber(epsilon2)){
        // LJ parameters for Atom 2.
        s2 = sigma2;
        e2 = epsilon2;
    }

    else {
        s2 = s1;
        e2 = e1;
    }

    // Calculating combined LJ parameters.
    this.calcSigma(s1, s2);
    this.calcEpsilon(e1, e2);
};

LJ.prototype.calcSigma = function(s1, s2) {
    this.s = (s1 + s2) / 2
};

LJ.prototype.calcEpsilon = function(e1, e2) {
    this.e = Math.sqrt(e1 * e2);
};

/**
 * Calculate LJ potential.
 * @param r: Distance from LJ centre.
 * @returns {number} Net potential due to potential
 */
LJ.prototype.calcV = function(r) {
    var repulsive = Math.pow(this.s / r, 12);                   // Repulsive factors.
    var attractive = -1 * Math.pow(this.s / r, 6);              // Attractive factors.
    return 4 * this.e * (repulsive + attractive);
};

/**
 * Calculates LJ potential corrected for centrifugal force effects.
 * @param r: separation of atoms
 * @param L: Angular momentum
 * @param mu: Reduced mass of diatomic molecule.
 * @returns {number} Corrected potential
 */
LJ.prototype.calcCorrV = function(r, L, mu) {
    return (this.calcV(r) + Math.pow(L / r, 2) / (2 * mu));
};

/**
 * Calculates force on each atom in molecule due to LJ potential.
 * @param r: Separation
 * @returns {number} Net force due to potential
 */
LJ.prototype.calcF = function(r) {
    var repulsive = 12 * Math.pow(this.s / r, 12);              // Repulsive force.
    var attractive = -6 * Math.pow(this.s / r, 6);              // Attractive force.
    return 4 * this.e * ((repulsive + attractive) / r);
};

/**
 *
 * @returns {number} Separation at which potential is 0.
 */
LJ.prototype.getR_0 = function(){
    return Math.pow(2, 1/6) * this.s;
};

/**
 * Generates two arrays of points that can be used to plot the potential against separation to visualise the form of the
 * instance of LJ potential.
 * @param ppu: Points per unit of separation.
 * @returns {{x: Array, y: Array, name: string, mode: string, line: {width: number, opacity: number, color: string}}}
 * JS object that can be plotted by Plotly.
 */
LJ.prototype.plotLJ = function(ppu) {
    var r = [];                                                         // Array to store separation in.
    var v = [];                                                         // Array to store corresponding potential in.

    // Taking points upto 3 * sigma.
    for (var i = 1; i < Math.ceil(this.s * 3 * ppu); i++) {
        r.push(i / ppu);
        v.push(this.calcV(i / ppu));
    }
    return {x: r, y: v, name: "V" + "LJ".sub() + "(r)", mode: "lines",
        line: {width: this.e / 10, opacity: 0.8, color: "#003E74"}};
};

/**
 * Generates two arrays of points that can be used to plot the corrected potential against separation to visualise the
 * form of the instance of LJ potential due to centrifugal effects.
 * @param ppu: Points per unit of separation
 * @param L: Angular momentum of molecule.
 * @param mu: Reduced mass of molecule.
 * @returns {{x: Array, y: Array, name: string, mode: string, line: {width: number, opacity: number, color: string}}}
 * JS object that can be plotted by Plotly.
 */
LJ.prototype.plotLJCorr = function (ppu, L, mu) {
    var r = [];
    var v = [];

    for (var i = 1; i < Math.ceil(this.s * 3 * ppu); i++){
        r.push(i / ppu);
        v.push(this.calcCorrV(i / ppu, L, mu));
    }
    return {x:r, y:v, name:"EP", mode:"lines",
        line: {width: this.e / 10, opacity:0.8, color:'#FF0000'}};
};


/** ============================================ Class Declarations ==============================================*/
/**
 * Class to describe attributes of atoms that can be used to make up molecules.
 * @param mass: Mass of atom.
 * @param color: Color of atom for phaser code.(cosmetic only)
 * @constructor: Atom
 */
Atom = function( mass, color) {
    this.pos = [];                 // Atom position Vector.

    // Checking for unphysical parameters.
    if ( mass <= 0) {
        console.error("Unphysical system detected! Please check radius, mass and charge values.");

        // Correcting to physical values.
        mass = -mass;
    }
    this.color = color;
    this.mass = mass;
    this.radius = Math.sqrt(this.mass);// Atom mass.
    this.sprite = addAtom(this);
};

/**
 * Finds last position of Atom.
 * @returns {number} Phaser coords.
 */
Atom.prototype.getPos = function(){
    if(this.pos.length === 0 ) return;
    return this.pos[this.pos.length - 1];
};

/**
 * Updates Array of past coordinates of atoms.
 * @param newPos: New position to add to array.
 */
Atom.prototype.setPos = function(newPos){
    if(this.pos.length > 90) this.pos.shift();      // Storing last 90 positions, deleting older ones
    this.pos.push(newPos);                          // Pushing new position.
};

/**
 * Class to make molecule out of atoms, with a spring constant that defines strength of bonds, and instantiated with
 * rotational and vibrational E.
 * @param a1: Atom 1.
 * @param a2: Atom 2.
 * @param potential: Potential describing bond between atoms.
 * @param keVib_0: Vibrational kinetic energy at t=0.
 * @param keRot_0: Rotational kinetic energy at t=0.
 * @constructor
 */
Molecule = function(a1, a2, potential, keVib_0, keRot_0) {
    // Checking objects of class Atom passed in in the list.
    if (a1.constructor !== Atom || a2.constructor !== Atom){
        console.error("Can't run simulation without two valid atom objects");
    }
    this.a1 = a1;
    this.a2 = a2;
    this.V = potential;                                         // Potential used as a bond between atoms.
    this.maxKE_V = keVib_0;
    this.tot_m =(a1.mass + a2.mass);                            // Finding total mass of the system.
    this.reducedM =  (a1.mass * a2.mass) / (this.tot_m);        // Finding system's reduced mass.

    this.I =  this.reducedM * Math.pow(this.V.getR_0(), 2);     // Calculate initial Moment of Inertia.
    this.omega = Math.sqrt(2 * keRot_0 / this.I);               // Calculate initial angular velocity.
    this.L = this.I * this.omega;                               // Calculate angular momentum (conserved).
    this.separation = this.init_r_0(0.0001, this.L);            // Initial separation (scalar).
    this.r = new Vector([1, 0]).multiply(this.separation);      // Initial separation (vector).
    this.v = Math.sqrt(2 * keVib_0 / this.reducedM);            // Initial linear velocity of molecule.

    // System's vibrational & rotational KEs, and total energy.
    this.KE_V = this.getKE_V();
    this.KE_R = this.getKE_R();
    this.PE = this.getPE();
    this.effPE = this.getCorrPE();
    this.tot_E = keVib_0 + this.effPE;

    a1.setPos(this.r.multiply(a1.mass / this.tot_m));
    a2.setPos(this.r.multiply(-a2.mass / this.tot_m));


};

/**
 *  Calculates the centrifugally corrected value of r at the time t = 0 seconds.
 * @returns {number} Corrected value of r_0
 */
Molecule.prototype.init_r_0 = function(resolution, L) {
        var min = [0, Number.MAX_VALUE];
        for(var i = Math.floor(0.75*this.V.getR_0()/resolution); i < Math.ceil(1.25*this.V.getR_0()/resolution); i++){
            var potVal = this.V.calcV(i*resolution) +  Math.pow(L/(i*resolution),2)/(2 * this.reducedM);
            if(min[1] > potVal) min = [i*resolution,potVal];
        }
        return min[0];
};

/**
 * Calculates the potential energy of the system using the potential function instantiated to the molecule.
 * @returns {Number} System PE.
 */
Molecule.prototype.update = function(deltaTime){

    // Recalculate MoI and angular velocity.
    this.I = this.calcMoI();
    this.omega = this.calcAngVel();

    // Rotate and vibrate.
    this.calcRotCoords(deltaTime);
    this.calcExtCoords(deltaTime);

    this.separation = this.getSeparation();
    this.KE_V = this.getKE_V();
    this.KE_R = this.getKE_R();
    this.PE = this.getPE();
    this.effPE = this.getCorrPE();

    // Update atom coordinates in CoM frame.
    a1.setPos(this.r.multiply(a1.mass / this.tot_m));
    a2.setPos(this.r.multiply(-a2.mass / this.tot_m));
};

/**
 * Function to calculate extended coordinates due to vibrational energy.
 * @param dT: Time elapsed since previous timestep.
 */
Molecule.prototype.calcExtCoords = function (dT) {
    var a = (this.V.calcF(this.separation) / this.reducedM) +  Math.pow(this.omega, 2) * this.separation;
    this.v += a * dT;
    this.r = this.r.add(this.r.unit().multiply(this.v * dT));
};

/**
 * Updates KE_rot and I, and finally outputs rotated separation vector.
 * @param dt: Timestep
 * @returns {Vector} Separation vector, r.
 */
Molecule.prototype.calcRotCoords = function(dt) {
    this.r = this.r.rotate(this.omega * dt);
};

/**
 * Updates CoM coordinates and calculates Moment of Inertia.
 * @returns {number} I
 */
Molecule.prototype.calcMoI = function() {
    return this.reducedM * Math.pow(this.separation, 2);                            // Return Moment of Inertia (scalar).
};

/**
 * Calculates angular velocity using KE_rot and MoI.
 * @returns {Number} Angular velocity, rad s^(-1)
 */
Molecule.prototype.calcAngVel = function () {
    return this.L / this.I;
};

/**
 * Gets vector from one atom to another.
 */
Molecule.prototype.calcDir = function() {
    return (a1.getPos().subtract(a2.getPos())).unit();
};

/**
 * Calculates rotational KE.
 * @returns {number} Rotational KE.
 */
Molecule.prototype.getKE_R = function () {
    return 0.5 * this.I * Math.pow(this.omega, 2);
};

/**
 * Calculates vibrational KE.
 * @returns {number} Vibrational KE
 */
Molecule.prototype.getKE_V = function () {
    return 0.5 * this.reducedM * Math.pow(this.v, 2);
};

/**
 * Gets Potential Energy.
 * @returns {number} Ideal LJ PE.
 */
Molecule.prototype.getPE = function() {
    return this.V.calcV(this.separation);
};

/**
 * Gets corrected Potential Energy due to rotation.
 * @returns {number} Corrected PE.
 */
Molecule.prototype.getCorrPE = function() {
    return this.V.calcCorrV(this.separation, this.L, this.reducedM);
};

/**
 * Finds scalar separation of atoms.
 * @returns {number} Distance
 */
Molecule.prototype.getSeparation = function() {
    return this.r.mag();
};

/**
 * Creates new molecule object with no change in direction or separation.
 * @param ke_vib0: Slider value of KE_vib.
 * @param ke_rot0: Slider value of KE_rot.
 * @returns {Molecule} New molecule.
 */
Molecule.prototype.softReset = function (ke_vib0, ke_rot0) {
    var dir = this.calcDir();
    var new_mol = new Molecule(this.a1, this.a2, this.V, ke_vib0, ke_rot0);

    // Is current separation more than new equilibrium separation?
    var bool_r = (new_mol.separation < this.separation);
    var vReverse = 0;
    var vDir = (this.v / new_mol.v > 0);

    // Update new molecule until new molecule has either passed separation value of current molecule.
    while ((new_mol.separation < this.separation) === bool_r) {

        // Update number of times direction has been changed.
        if ((this.v / new_mol.v > 0) !== vDir) vReverse++;

        // If velocity hasn't changed direction twice, then some separation values yet to be tested for crossing.
        if (vReverse < 2) {
            new_mol.update(1/300);                                          // Time step << dT to ensure minimal errors.
        }

        // If velocity direction has changed twice, then all possible separation values covered - exiting loop.
        else {
            new_mol.r = dir.multiply(new_mol.separation);   // Keeping orientation of molecule same, extreme separation.
            new_mol.a1.pos = this.a1.pos; new_mol.a2.pos = this.a2.pos;     // Updating new molecule's position Arrays.
            new_mol.omega = this.omega;                                     // Keeping angular momentum same.
            console.log("New molecule's maximum separation cannot reach current separation! Hard resetting...");

            if (Math.sign(this.v) !== Math.sign(new_mol.v)) new_mol.v = -new_mol.v;

            return new_mol
        }
    }

    // In case separation has been matched, by above loop, then returning updating new molecule to ensure continuity.
    new_mol.a1.pos = this.a1.pos; new_mol.a2.pos = this.a2.pos;             // Updating new molecule's position Arrays.
    new_mol.r = dir.multiply(new_mol.separation);           // Keeping orientation of molecule same, extreme separation.
    new_mol.a1.pos.splice(-1, 1); new_mol.a2.pos.splice(-1, 1);             // Cleaning up trail.
    if (Math.sign(this.v) !== Math.sign(new_mol.v)) new_mol.v = -new_mol.v;
    return new_mol;
};